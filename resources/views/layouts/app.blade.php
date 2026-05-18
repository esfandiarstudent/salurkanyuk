<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — SalurkanYuk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script>tailwind.config={theme:{extend:{fontFamily:{sans:['Plus Jakarta Sans','sans-serif']}}}}</script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 10px; }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 h-full">
<div class="flex h-screen overflow-hidden">

    {{-- Sidebar --}}
    <aside class="w-64 bg-white border-r border-gray-100 flex flex-col fixed inset-y-0 left-0 z-50 shadow-sm">

        {{-- Logo --}}
        <div class="px-6 py-5 border-b border-gray-100">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-700 rounded-xl flex items-center justify-center shadow-md">
                    <i class="fa-solid fa-hand-holding-heart text-white text-lg"></i>
                </div>
                <div>
                    <div class="font-extrabold text-gray-900 text-base leading-tight">SalurkanYuk</div>
                    <div class="text-xs text-gray-400">Platform Donasi Barang</div>
                </div>
            </a>
        </div>

        {{-- User info --}}
        <div class="px-4 py-3 border-b border-gray-100">
            <div class="flex items-center gap-3 p-2.5 rounded-xl bg-gray-50">
                <img src="{{ Auth::user()->photo_url }}" alt="Avatar" class="w-10 h-10 rounded-xl object-cover flex-shrink-0">
                <div class="flex-1 min-w-0">
                    <div class="font-semibold text-gray-900 text-sm truncate">{{ Auth::user()->name }}</div>
                    <div class="text-xs font-medium flex items-center gap-1.5 mt-0.5
                        {{ Auth::user()->role==='donatur'?'text-green-600':(Auth::user()->role==='admin'?'text-purple-600':'text-blue-600') }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ Auth::user()->role==='donatur'?'bg-green-500':(Auth::user()->role==='admin'?'bg-purple-500':'bg-blue-500') }}"></span>
                        {{ ucfirst(Auth::user()->role) }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 py-4 overflow-y-auto space-y-1">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest px-3 pb-2">Menu Utama</p>

            {{-- Dashboard - Green --}}
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150
               {{ request()->routeIs('dashboard')
                  ? 'bg-green-600 text-white shadow-sm'
                  : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                <span class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0
                    {{ request()->routeIs('dashboard') ? 'bg-white/20' : 'bg-green-100 text-green-600' }}">
                    <i class="fa-solid fa-house text-xs"></i>
                </span>
                <span>Dashboard</span>
            </a>

            {{-- Barang Donasi - Blue --}}
            <a href="{{ route('donations.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150
               {{ request()->routeIs('donations.*')
                  ? 'bg-blue-600 text-white shadow-sm'
                  : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }}">
                <span class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0
                    {{ request()->routeIs('donations.*') ? 'bg-white/20' : 'bg-blue-100 text-blue-600' }}">
                    <i class="fa-solid fa-box-open text-xs"></i>
                </span>
                <span>Barang Donasi</span>
            </a>

            {{-- Kategori - Orange --}}
            <a href="{{ route('categories.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150
               {{ request()->routeIs('categories.*')
                  ? 'bg-orange-500 text-white shadow-sm'
                  : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                <span class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0
                    {{ request()->routeIs('categories.*') ? 'bg-white/20' : 'bg-orange-100 text-orange-500' }}">
                    <i class="fa-solid fa-tags text-xs"></i>
                </span>
                <span>Kategori</span>
            </a>

            {{-- Pengajuan Klaim - Purple --}}
            <a href="{{ route('requests.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150
               {{ request()->routeIs('requests.*')
                  ? 'bg-purple-600 text-white shadow-sm'
                  : 'text-gray-600 hover:bg-purple-50 hover:text-purple-700' }}">
                <span class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0
                    {{ request()->routeIs('requests.*') ? 'bg-white/20' : 'bg-purple-100 text-purple-600' }}">
                    <i class="fa-solid fa-clipboard-list text-xs"></i>
                </span>
                <span>Pengajuan Klaim</span>
            </a>

            {{-- Riwayat Donasi - Teal --}}
            <a href="{{ route('history.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150
               {{ request()->routeIs('history.*')
                  ? 'bg-teal-600 text-white shadow-sm'
                  : 'text-gray-600 hover:bg-teal-50 hover:text-teal-700' }}">
                <span class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0
                    {{ request()->routeIs('history.*') ? 'bg-white/20' : 'bg-teal-100 text-teal-600' }}">
                    <i class="fa-solid fa-clock-rotate-left text-xs"></i>
                </span>
                <span>Riwayat Donasi</span>
            </a>

            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest px-3 pt-3 pb-2">Akun</p>

            {{-- Profil - Pink --}}
            <a href="{{ route('profile.show') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150
               {{ request()->routeIs('profile.*')
                  ? 'bg-pink-500 text-white shadow-sm'
                  : 'text-gray-600 hover:bg-pink-50 hover:text-pink-600' }}">
                <span class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0
                    {{ request()->routeIs('profile.*') ? 'bg-white/20' : 'bg-pink-100 text-pink-500' }}">
                    <i class="fa-solid fa-circle-user text-xs"></i>
                </span>
                <span>Profil Saya</span>
            </a>
        </nav>

        {{-- Logout --}}
        <div class="px-3 py-4 border-t border-gray-100">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-red-500 hover:bg-red-50 hover:text-red-600 transition-all">
                    <span class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center text-red-500 flex-shrink-0">
                        <i class="fa-solid fa-right-from-bracket text-xs"></i>
                    </span>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- Main --}}
    <main class="ml-64 flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-100 px-8 py-4 flex items-center justify-between sticky top-0 z-10">
            <div>
                <h1 class="text-xl font-bold text-gray-900">@yield('page-title','Dashboard')</h1>
                <p class="text-sm text-gray-400 mt-0.5">@yield('page-subtitle','')</p>
            </div>
            <div class="flex items-center gap-3">
                @yield('header-action')
                <a href="{{ route('profile.show') }}" class="w-9 h-9 rounded-xl overflow-hidden ring-2 ring-green-100 hover:ring-green-300 transition">
                    <img src="{{ Auth::user()->photo_url }}" class="w-full h-full object-cover">
                </a>
            </div>
        </header>

        <div class="px-8 pt-5">
            @if(session('success'))
                <div class="mb-4 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-5 py-3.5 rounded-xl text-sm font-medium" id="flash-success">
                    <i class="fa-solid fa-circle-check text-green-500"></i>{{ session('success') }}
                    <button onclick="this.parentElement.remove()" class="ml-auto text-green-400 hover:text-green-600"><i class="fa-solid fa-xmark"></i></button>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-5 py-3.5 rounded-xl text-sm font-medium">
                    <i class="fa-solid fa-circle-exclamation text-red-500"></i>{{ session('error') }}
                    <button onclick="this.parentElement.remove()" class="ml-auto text-red-400 hover:text-red-600"><i class="fa-solid fa-xmark"></i></button>
                </div>
            @endif
            @if($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-5 py-3.5 rounded-xl text-sm">
                    <div class="font-semibold mb-1"><i class="fa-solid fa-triangle-exclamation mr-2"></i>Terdapat kesalahan:</div>
                    <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{$e}}</li>@endforeach</ul>
                </div>
            @endif
        </div>

        <div class="flex-1 overflow-y-auto px-8 pb-8">@yield('content')</div>
    </main>
</div>
<script>setTimeout(()=>{document.getElementById('flash-success')?.remove();},4000);</script>
@stack('scripts')
</body>
</html>
