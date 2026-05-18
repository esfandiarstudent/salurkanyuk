@extends('layouts.auth')
@section('title', 'Masuk')

@section('content')
<h2 class="text-2xl font-bold text-gray-900 mb-1">Selamat Datang!</h2>
<p class="text-gray-500 text-sm mb-7">Masuk untuk mulai berbagi kebaikan.</p>

<form method="POST" action="/login" class="space-y-5">
    @csrf
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
        <div class="relative">
            <span class="absolute left-3.5 top-3 text-gray-400"><i class="fa-solid fa-envelope text-sm"></i></span>
            <input type="email" name="email" value="{{ old('email') }}" required
                class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-green-300 focus:border-green-400 outline-none transition @error('email') border-red-300 @enderror"
                placeholder="email@example.com">
        </div>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
        <div class="relative">
            <span class="absolute left-3.5 top-3 text-gray-400"><i class="fa-solid fa-lock text-sm"></i></span>
            <input type="password" name="password" required
                class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-green-300 focus:border-green-400 outline-none transition"
                placeholder="••••••••">
        </div>
    </div>
    <div class="flex items-center justify-between">
        <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
            <input type="checkbox" name="remember" class="rounded border-gray-300 text-green-600 focus:ring-green-400">
            Ingat saya
        </label>
    </div>
    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-xl transition-all duration-200 text-sm shadow-sm hover:shadow-md">
        <i class="fa-solid fa-right-to-bracket mr-2"></i>Masuk
    </button>
</form>

<div class="mt-6 text-center text-sm text-gray-500">
    Belum punya akun?
    <a href="/register" class="text-green-600 font-semibold hover:text-green-700">Daftar sekarang</a>
</div>
@endsection
