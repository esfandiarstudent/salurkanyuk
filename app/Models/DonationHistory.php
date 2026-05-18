<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationHistory extends Model
{
    use HasFactory;

    protected $table = 'donation_history';

    protected $fillable = [
        'item_id', 'donor_id', 'receiver_id', 'status', 'note', 'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function item()
    {
        return $this->belongsTo(DonationItem::class, 'item_id');
    }

    public function donor()
    {
        return $this->belongsTo(User::class, 'donor_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'selesai'    => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">Selesai</span>',
            'dibatalkan' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">Dibatalkan</span>',
            default      => '',
        };
    }
}
