<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'category_id', 'title', 'description',
        'photo', 'quantity', 'status', 'location',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function requests()
    {
        return $this->hasMany(DonationRequest::class, 'item_id');
    }

    public function history()
    {
        return $this->hasOne(DonationHistory::class, 'item_id');
    }

    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        return 'https://placehold.co/400x300/e8f5e9/16a34a?text=No+Photo';
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'tersedia' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">Tersedia</span>',
            'diklaim'  => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">Diklaim</span>',
            'selesai'  => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600">Selesai</span>',
            default    => '',
        };
    }
}
