@extends('layouts.auth')
@section('title', 'Daftar')

@section('content')
<h2 class="text-2xl font-bold text-gray-900 mb-1">Buat Akun Baru</h2>
<p class="text-gray-500 text-sm mb-7">Bergabunglah dan mulai berbagi kebaikan.</p>

<form method="POST" action="/register" class="space-y-5">
    @csrf
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
        <div class="relative">
            <span class="absolute left-3.5 top-3 text-gray-400"><i class="fa-solid fa-user text-sm"></i></span>
            <input type="text" name="name" value="{{ old('name') }}" required
                class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-green-300 focus:border-green-400 outline-none transition"
                placeholder="Nama Lengkap Anda">
        </div>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
        <div class="relative">
            <span class="absolute left-3.5 top-3 text-gray-400"><i class="fa-solid fa-envelope text-sm"></i></span>
            <input type="email" name="email" value="{{ old('email') }}" required
                class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-green-300 focus:border-green-400 outline-none transition"
                placeholder="email@example.com">
        </div>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">Daftar Sebagai</label>
        <div class="grid grid-cols-2 gap-3">
            <label class="role-card cursor-pointer">
                <input type="radio" name="role" value="donatur" class="sr-only peer" {{ old('role') === 'donatur' ? 'checked' : '' }}>
                <div class="border-2 border-gray-200 rounded-xl p-4 text-center transition peer-checked:border-green-500 peer-checked:bg-green-50 hover:border-green-300">
                    <div class="text-2xl mb-1">🎁</div>
                    <div class="font-semibold text-gray-800 text-sm">Donatur</div>
                    <div class="text-xs text-gray-500 mt-0.5">Saya ingin berdonasi</div>
                </div>
            </label>
            <label class="role-card cursor-pointer">
                <input type="radio" name="role" value="penerima" class="sr-only peer" {{ old('role', 'penerima') === 'penerima' ? 'checked' : '' }}>
                <div class="border-2 border-gray-200 rounded-xl p-4 text-center transition peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:border-blue-300">
                    <div class="text-2xl mb-1">🤲</div>
                    <div class="font-semibold text-gray-800 text-sm">Penerima</div>
                    <div class="text-xs text-gray-500 mt-0.5">Saya butuh bantuan</div>
                </div>
            </label>
        </div>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
        <div class="relative">
            <span class="absolute left-3.5 top-3 text-gray-400"><i class="fa-solid fa-lock text-sm"></i></span>
            <input type="password" name="password" required
                class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-green-300 focus:border-green-400 outline-none transition"
                placeholder="Min. 8 karakter">
        </div>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Konfirmasi Password</label>
        <div class="relative">
            <span class="absolute left-3.5 top-3 text-gray-400"><i class="fa-solid fa-lock text-sm"></i></span>
            <input type="password" name="password_confirmation" required
                class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-green-300 focus:border-green-400 outline-none transition"
                placeholder="Ulangi password">
        </div>
    </div>
    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-xl transition-all duration-200 text-sm shadow-sm hover:shadow-md">
        <i class="fa-solid fa-user-plus mr-2"></i>Buat Akun
    </button>
</form>

<div class="mt-6 text-center text-sm text-gray-500">
    Sudah punya akun?
    <a href="/login" class="text-green-600 font-semibold hover:text-green-700">Masuk di sini</a>
</div>
@endsection
