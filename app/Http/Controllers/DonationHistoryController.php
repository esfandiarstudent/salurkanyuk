<?php

namespace App\Http\Controllers;

use App\Models\DonationHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationHistoryController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = DonationHistory::with(['item.category', 'donor', 'receiver']);

        if ($user->isDonatur()) {
            $query->where('donor_id', $user->id);
        } elseif ($user->isPenerima()) {
            $query->where('receiver_id', $user->id);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->date_from) {
            $query->whereDate('completed_at', '>=', $request->date_from);
        }
        if ($request->date_to) {
            $query->whereDate('completed_at', '<=', $request->date_to);
        }

        $histories = $query->latest('completed_at')->paginate(15);
        return view('history.index', compact('histories'));
    }

    public function update(Request $request, DonationHistory $donationHistory)
    {
        abort_unless($donationHistory->donor_id === Auth::id(), 403);

        $request->validate([
            'status' => 'required|in:selesai,dibatalkan',
            'note'   => 'nullable|string',
        ]);

        $donationHistory->update([
            'status'       => $request->status,
            'note'         => $request->note,
            'completed_at' => now(),
        ]);

        if ($request->status === 'dibatalkan') {
            $donationHistory->item->update(['status' => 'tersedia']);
        }

        return back()->with('success', 'Status donasi berhasil diperbarui!');
    }
}
