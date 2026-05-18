<?php

namespace App\Http\Controllers;

use App\Models\DonationItem;
use App\Models\DonationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationRequestController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isDonatur()) {
            // Donatur sees requests for their items
            $requests = DonationRequest::whereHas('item', fn($q) => $q->where('user_id', $user->id))
                ->with(['item', 'user'])
                ->latest()
                ->paginate(15);
        } else {
            // Penerima sees their own requests
            $requests = DonationRequest::where('user_id', $user->id)
                ->with(['item.category', 'item.user'])
                ->latest()
                ->paginate(15);
        }

        return view('requests.index', compact('requests'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:donation_items,id',
            'message' => 'required|string|min:20',
        ]);

        $item = DonationItem::findOrFail($request->item_id);
        if ($item->status !== 'tersedia') {
            return back()->with('error', 'Barang ini sudah tidak tersedia.');
        }

        $existing = DonationRequest::where('item_id', $request->item_id)
            ->where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'disetujui'])
            ->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah mengajukan klaim untuk barang ini.');
        }

        DonationRequest::create([
            'item_id' => $request->item_id,
            'user_id' => Auth::id(),
            'message' => $request->message,
            'status'  => 'pending',
        ]);

        return redirect()->route('requests.index')->with('success', 'Pengajuan klaim berhasil dikirim!');
    }

    public function destroy(DonationRequest $donationRequest)
    {
        abort_unless($donationRequest->user_id === Auth::id(), 403);
        abort_unless($donationRequest->status === 'pending', 403);
        $donationRequest->delete();
        return back()->with('success', 'Pengajuan klaim berhasil dibatalkan.');
    }
}
