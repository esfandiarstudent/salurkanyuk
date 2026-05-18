@extends('layouts.app')
@section('title','Profil Saya')
@section('page-title','Profil Saya')
@section('page-subtitle','Informasi akun Anda')

@section('header-action')
    <a href="{{ route('profile.edit') }}"
       class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition-all shadow-sm">
        <i class="fa-solid fa-pen"></i> Edit Profil
    </a>
@endsection

@section('content')
<div class="pt-2 grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Profile Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center">
        <div class="relative inline-block mb-5">
            <img src="{{ $user->photo_url }}" alt="{{ $user->name }}"
                 class="w-28 h-28 rounded-2xl object-cover mx-auto ring-4
                 {{ $user->isDonatur()?'ring-green-100':($user->isAdmin()?'ring-purple-100':'ring-blue-100') }}">
            <div class="absolute -bottom-2 -right-2 w-8 h-8 rounded-xl flex items-center justify-center shadow-md
                {{ $user->isDonatur()?'bg-green-500':($user->isAdmin()?'bg-purple-500':'bg-blue-500') }}">
                <i class="fa-solid {{ $user->isDonatur()?'fa-heart':($user->isAdmin()?'fa-shield':'fa-hand') }} text-white text-xs"></i>
            </div>
        </div>
        <h2 class="text-xl font-extrabold text-gray-900 mb-2">{{ $user->name }}</h2>
        <span class="inline-block px-4 py-1.5 rounded-full text-xs font-bold capitalize
            {{ $user->isDonatur()?'bg-green-100 text-green-700':($user->isAdmin()?'bg-purple-100 text-purple-700':'bg-blue-100 text-blue-700') }}">
            <i class="fa-solid {{ $user->isDonatur()?'fa-heart':($user->isAdmin()?'fa-shield':'fa-hand') }} mr-1 text-[10px]"></i>
            {{ $user->role }}
        </span>

        <div class="mt-6 space-y-3 text-left">
            <div class="flex items-center gap-3 text-sm text-gray-600">
                <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center text-blue-400 flex-shrink-0">
                    <i class="fa-solid fa-envelope text-xs"></i>
                </div>
                <span class="truncate text-gray-700">{{ $user->email }}</span>
            </div>
            @if($user->phone)
            <div class="flex items-center gap-3 text-sm text-gray-600">
                <div class="w-9 h-9 bg-green-50 rounded-xl flex items-center justify-center text-green-400 flex-shrink-0">
                    <i class="fa-solid fa-phone text-xs"></i>
                </div>
                <span class="text-gray-700">{{ $user->phone }}</span>
            </div>
            @endif
            @if($user->address)
            <div class="flex items-start gap-3 text-sm text-gray-600">
                <div class="w-9 h-9 bg-orange-50 rounded-xl flex items-center justify-center text-orange-400 flex-shrink-0">
                    <i class="fa-solid fa-location-dot text-xs"></i>
                </div>
                <span class="text-gray-700 leading-relaxed">{{ $user->address }}</span>
            </div>
            @endif
            <div class="flex items-center gap-3 text-sm text-gray-600">
                <div class="w-9 h-9 bg-purple-50 rounded-xl flex items-center justify-center text-purple-400 flex-shrink-0">
                    <i class="fa-solid fa-calendar text-xs"></i>
                </div>
                <span class="text-gray-700">Bergabung {{ $user->created_at->format('d M Y') }}</span>
            </div>
        </div>
    </div>

    {{-- Right Column --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Stats --}}
        <div class="grid grid-cols-3 gap-4">
            @if($user->isDonatur())
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-5 text-center text-white shadow-sm">
                    <div class="text-3xl font-extrabold mb-1">{{ $user->donationItems->count() }}</div>
                    <div class="text-xs font-medium opacity-90">Total Barang</div>
                </div>
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-5 text-center text-white shadow-sm">
                    <div class="text-3xl font-extrabold mb-1">{{ $user->donationItems->where('status','tersedia')->count() }}</div>
                    <div class="text-xs font-medium opacity-90">Tersedia</div>
                </div>
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-5 text-center text-white shadow-sm">
                    <div class="text-3xl font-extrabold mb-1">{{ $user->donationsAsDonor->where('status','selesai')->count() }}</div>
                    <div class="text-xs font-medium opacity-90">Selesai</div>
                </div>
            @else
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-5 text-center text-white shadow-sm">
                    <div class="text-3xl font-extrabold mb-1">{{ $user->donationRequests->count() }}</div>
                    <div class="text-xs font-medium opacity-90">Total Pengajuan</div>
                </div>
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-5 text-center text-white shadow-sm">
                    <div class="text-3xl font-extrabold mb-1">{{ $user->donationRequests->where('status','disetujui')->count() }}</div>
                    <div class="text-xs font-medium opacity-90">Disetujui</div>
                </div>
                <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl p-5 text-center text-white shadow-sm">
                    <div class="text-3xl font-extrabold mb-1">{{ $user->donationRequests->where('status','pending')->count() }}</div>
                    <div class="text-xs font-medium opacity-90">Menunggu</div>
                </div>
            @endif
        </div>

        {{-- Change Password --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-lock text-red-500"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900">Ubah Password</h3>
                    <p class="text-xs text-gray-400">Pastikan gunakan password yang kuat</p>
                </div>
            </div>
            <form method="POST" action="{{ route('profile.password') }}" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password Saat Ini</label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-3 text-gray-400"><i class="fa-solid fa-lock text-xs"></i></span>
                        <input type="password" name="current_password" required
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-red-200 focus:border-red-400 outline-none transition"
                            placeholder="Password lama Anda">
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password Baru</label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-3 text-gray-400"><i class="fa-solid fa-key text-xs"></i></span>
                            <input type="password" name="password" required minlength="8"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-200 focus:border-blue-400 outline-none transition"
                                placeholder="Min. 8 karakter">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Konfirmasi Password</label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-3 text-gray-400"><i class="fa-solid fa-check text-xs"></i></span>
                            <input type="password" name="password_confirmation" required
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-200 focus:border-blue-400 outline-none transition"
                                placeholder="Ulangi password baru">
                        </div>
                    </div>
                </div>
                <div class="flex gap-3 pt-1">
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white font-semibold px-6 py-2.5 rounded-xl text-sm transition-all shadow-sm">
                        <i class="fa-solid fa-lock"></i> Simpan Password
                    </button>
                    <a href="{{ route('profile.edit') }}"
                        class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2.5 rounded-xl text-sm transition-all shadow-sm">
                        <i class="fa-solid fa-pen"></i> Edit Profil
                    </a>
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-700 font-semibold px-6 py-2.5 rounded-xl text-sm border border-gray-200 transition-all">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
