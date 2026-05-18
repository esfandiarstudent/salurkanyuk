<?php

namespace App\Http\Controllers;

use App\Models\DonationItem;
use App\Models\DonationRequest;
use App\Models\DonationHistory;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $stats = [];

        if ($user->isDonatur()) {
            $stats = [
                'total_barang'    => DonationItem::where('user_id', $user->id)->count(),
                'tersedia'        => DonationItem::where('user_id', $user->id)->where('status', 'tersedia')->count(),
                'pending_klaim'   => DonationRequest::whereHas('item', fn($q) => $q->where('user_id', $user->id))->where('status', 'pending')->count(),
                'selesai'         => DonationHistory::where('donor_id', $user->id)->where('status', 'selesai')->count(),
            ];
            $recentItems = DonationItem::where('user_id', $user->id)->with('category')->latest()->take(5)->get();
        } elseif ($user->isPenerima()) {
            $stats = [
                'pengajuan'       => DonationRequest::where('user_id', $user->id)->count(),
                'pending'         => DonationRequest::where('user_id', $user->id)->where('status', 'pending')->count(),
                'disetujui'       => DonationRequest::where('user_id', $user->id)->where('status', 'disetujui')->count(),
                'tersedia'        => DonationItem::where('status', 'tersedia')->count(),
            ];
            $recentItems = DonationItem::where('status', 'tersedia')->with(['category', 'user'])->latest()->take(6)->get();
        } else {
            // Admin
            $stats = [
                'total_user'     => User::count(),
                'total_barang'   => DonationItem::count(),
                'total_kategori' => Category::count(),
                'total_donasi'   => DonationHistory::count(),
            ];
            $recentItems = DonationItem::with(['category', 'user'])->latest()->take(5)->get();
        }

        $categories = Category::withCount('donationItems')->get();

        return view('dashboard', compact('user', 'stats', 'recentItems', 'categories'));
    }
}
