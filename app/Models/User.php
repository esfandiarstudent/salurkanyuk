<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'photo', 'phone', 'address',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function donationItems()
    {
        return $this->hasMany(DonationItem::class);
    }

    public function donationRequests()
    {
        return $this->hasMany(DonationRequest::class);
    }

    public function donationsAsDonor()
    {
        return $this->hasMany(DonationHistory::class, 'donor_id');
    }

    public function donationsAsReceiver()
    {
        return $this->hasMany(DonationHistory::class, 'receiver_id');
    }

    public function isDonatur()
    {
        return $this->role === 'donatur';
    }

    public function isPenerima()
    {
        return $this->role === 'penerima';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=16a34a&color=fff&size=128';
    }
}
