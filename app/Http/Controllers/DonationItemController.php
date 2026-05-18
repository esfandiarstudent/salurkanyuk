<?php

namespace App\Http\Controllers;

use App\Models\DonationItem;
use App\Models\DonationRequest;
use App\Models\DonationHistory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DonationItemController extends Controller
{
    public function index(Request $request)
    {
        $query = DonationItem::with(['user', 'category']);

        if (Auth::user()->isDonatur()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('status', 'tersedia');
        }

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $items = $query->latest()->paginate(12);
        $categories = Category::all();

        return view('donations.index', compact('items', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('donations.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:200',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'quantity'    => 'required|integer|min:1',
            'location'    => 'required|string|max:255',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('donations', 'public');
        }

        DonationItem::create([
            'user_id'     => Auth::id(),
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'description' => $request->description,
            'quantity'    => $request->quantity,
            'location'    => $request->location,
            'photo'       => $photoPath,
            'status'      => 'tersedia',
        ]);

        return redirect()->route('donations.index')->with('success', 'Barang donasi berhasil diposting!');
    }

    public function show(DonationItem $donation)
    {
        $donation->load(['user', 'category', 'requests.user']);
        $userRequest = null;
        if (Auth::user()->isPenerima()) {
            $userRequest = DonationRequest::where('item_id', $donation->id)
                ->where('user_id', Auth::id())->first();
        }
        return view('donations.show', compact('donation', 'userRequest'));
    }

    public function edit(DonationItem $donation)
    {
        abort_unless($donation->user_id === Auth::id(), 403);
        $categories = Category::all();
        return view('donations.edit', compact('donation', 'categories'));
    }

    public function update(Request $request, DonationItem $donation)
    {
        abort_unless($donation->user_id === Auth::id(), 403);

        $request->validate([
            'title'       => 'required|string|max:200',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'quantity'    => 'required|integer|min:1',
            'location'    => 'required|string|max:255',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $photoPath = $donation->photo;
        if ($request->hasFile('photo')) {
            if ($photoPath) Storage::disk('public')->delete($photoPath);
            $photoPath = $request->file('photo')->store('donations', 'public');
        }

        $donation->update([
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'description' => $request->description,
            'quantity'    => $request->quantity,
            'location'    => $request->location,
            'photo'       => $photoPath,
        ]);

        return redirect()->route('donations.show', $donation)->with('success', 'Barang donasi berhasil diperbarui!');
    }

    public function destroy(DonationItem $donation)
    {
        abort_unless($donation->user_id === Auth::id() || Auth::user()->isAdmin(), 403);
        if ($donation->photo) Storage::disk('public')->delete($donation->photo);
        $donation->delete();
        return redirect()->route('donations.index')->with('success', 'Barang donasi berhasil dihapus!');
    }

    // Approve / Reject request (for donatur)
    public function approveRequest(DonationRequest $donationRequest)
    {
        abort_unless($donationRequest->item->user_id === Auth::id(), 403);

        $donationRequest->update(['status' => 'disetujui']);
        $donationRequest->item->update(['status' => 'diklaim']);

        // Reject other pending requests
        DonationRequest::where('item_id', $donationRequest->item_id)
            ->where('id', '!=', $donationRequest->id)
            ->where('status', 'pending')
            ->update(['status' => 'ditolak']);

        // Create history
        DonationHistory::create([
            'item_id'      => $donationRequest->item_id,
            'donor_id'     => Auth::id(),
            'receiver_id'  => $donationRequest->user_id,
            'status'       => 'selesai',
            'completed_at' => now(),
        ]);

        return back()->with('success', 'Pengajuan klaim berhasil disetujui!');
    }

    public function rejectRequest(DonationRequest $donationRequest)
    {
        abort_unless($donationRequest->item->user_id === Auth::id(), 403);
        $donationRequest->update(['status' => 'ditolak']);
        return back()->with('success', 'Pengajuan klaim ditolak.');
    }
}
