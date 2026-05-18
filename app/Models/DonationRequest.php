<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationRequest extends Model
{
    use HasFactory;

    protected $fillable = ['item_id', 'user_id', 'message', 'status'];

    public function item()
    {
        return $this->belongsTo(DonationItem::class, 'item_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending'   => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">Pending</span>',
            'disetujui' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">Disetujui</span>',
            'ditolak'   => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">Ditolak</span>',
            default     => '',
        };
    }
}
