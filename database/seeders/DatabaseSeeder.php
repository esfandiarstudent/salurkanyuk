<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use App\Models\DonationItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'     => 'Admin SalurkanYuk',
            'email'    => 'admin@salurkanyuk.id',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // Donatur
        $donatur = User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'donatur@salurkanyuk.id',
            'password' => Hash::make('password'),
            'role'     => 'donatur',
            'phone'    => '081234567890',
            'address'  => 'Jl. Veteran No. 1, Malang',
        ]);

        // Penerima
        User::create([
            'name'     => 'Siti Rahayu',
            'email'    => 'penerima@salurkanyuk.id',
            'password' => Hash::make('password'),
            'role'     => 'penerima',
            'phone'    => '089876543210',
            'address'  => 'Jl. Soekarno Hatta No. 55, Malang',
        ]);

        // Categories
        $categories = [
            ['name' => 'Pakaian',    'icon' => '👕', 'description' => 'Baju, celana, jaket, sepatu, dan aksesori pakaian'],
            ['name' => 'Elektronik', 'icon' => '📱', 'description' => 'Ponsel, laptop, tablet, dan perangkat elektronik lainnya'],
            ['name' => 'Buku',       'icon' => '📚', 'description' => 'Buku pelajaran, novel, majalah, dan bacaan lainnya'],
            ['name' => 'Perabot',    'icon' => '🪑', 'description' => 'Kursi, meja, lemari, dan peralatan rumah tangga'],
            ['name' => 'Mainan',     'icon' => '🧸', 'description' => 'Mainan anak-anak layak pakai'],
            ['name' => 'Makanan',    'icon' => '🍱', 'description' => 'Bahan makanan dan makanan siap saji'],
            ['name' => 'Olahraga',   'icon' => '⚽', 'description' => 'Perlengkapan dan peralatan olahraga'],
            ['name' => 'Lainnya',    'icon' => '📦', 'description' => 'Barang lain yang belum masuk kategori tersedia'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Sample donation items
        $sampleItems = [
            ['title' => 'Baju Anak Usia 5-7 Tahun', 'category_id' => 1, 'description' => 'Baju anak kondisi baik, layak pakai. Ada 5 potong beragam warna.', 'quantity' => 5, 'location' => 'Kota Malang'],
            ['title' => 'Laptop Bekas Core i5', 'category_id' => 2, 'description' => 'Laptop masih berfungsi baik. RAM 8GB, SSD 256GB.', 'quantity' => 1, 'location' => 'Blimbing, Malang'],
            ['title' => 'Buku Pelajaran SMA', 'category_id' => 3, 'description' => 'Buku pelajaran kelas X-XII, lengkap semua mapel.', 'quantity' => 20, 'location' => 'Lowokwaru, Malang'],
            ['title' => 'Kursi Plastik', 'category_id' => 4, 'description' => 'Kursi plastik bekas kondisi layak pakai, tersedia 4 buah.', 'quantity' => 4, 'location' => 'Sukun, Malang'],
        ];

        foreach ($sampleItems as $item) {
            DonationItem::create(array_merge($item, ['user_id' => $donatur->id, 'status' => 'tersedia']));
        }
    }
}
