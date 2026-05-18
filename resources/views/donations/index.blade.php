@extends('layouts.app')
@section('title', 'Barang Donasi')
@section('page-title', 'Barang Donasi')
@section('page-subtitle', Auth::user()->isDonatur() ? 'Kelola barang donasi Anda' : 'Temukan barang yang Anda butuhkan')

@section('header-action')
    @if(Auth::user()->isDonatur())
        <a href="{{ route('donations.create') }}"
           class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition-all shadow-sm hover:shadow-md">
            <i class="fa-solid fa-plus"></i> Tambah Barang
        </a>
    @endif
@endsection

@section('content')
<div class="pt-2 space-y-5">

    {{-- Filter Bar --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <form method="GET" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Cari Barang</label>
                <div class="relative">
                    <i class="fa-solid fa-search absolute left-3.5 top-3 text-gray-400 text-sm"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama barang..."
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-200 focus:border-blue-400 outline-none transition">
                </div>
            </div>
            <div class="min-w-[160px]">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Kategori</label>
                <select name="category_id" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-200 focus:border-blue-400 outline-none transition">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            @if(Auth::user()->isDonatur())
            <div class="min-w-[140px]">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Status</label>
                <select name="status" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-200 focus:border-blue-400 outline-none transition">
                    <option value="">Semua Status</option>
                    <option value="tersedia" {{ request('status')==='tersedia'?'selected':'' }}>Tersedia</option>
                    <option value="diklaim"  {{ request('status')==='diklaim' ?'selected':'' }}>Diklaim</option>
                    <option value="selesai"  {{ request('status')==='selesai' ?'selected':'' }}>Selesai</option>
                </select>
            </div>
            @endif
            <button type="submit"
                class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition-all shadow-sm">
                <i class="fa-solid fa-filter"></i> Filter
            </button>
            @if(request()->hasAny(['search','category_id','status']))
                <a href="{{ route('donations.index') }}"
                   class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold px-5 py-2.5 rounded-xl text-sm transition-all">
                    <i class="fa-solid fa-xmark"></i> Reset
                </a>
            @endif
        </form>
    </div>

    {{-- Items Grid --}}
    @if($items->isEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center">
            <div class="w-20 h-20 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-box-open text-blue-300 text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Tidak ada barang ditemukan</h3>
            <p class="text-gray-400 text-sm mb-6">
                @if(Auth::user()->isDonatur()) Anda belum memposting barang donasi apapun. @else Belum ada barang donasi yang tersedia. @endif
            </p>
            @if(Auth::user()->isDonatur())
                <a href="{{ route('donations.create') }}"
                   class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition-all shadow-sm">
                    <i class="fa-solid fa-plus"></i> Tambah Barang Pertama
                </a>
            @endif
        </div>
    @else
        @php
            $cardColors = [
                ['top'=>'from-blue-400 to-blue-600',   'badge-bg'=>'bg-blue-50',   'badge-text'=>'text-blue-600'],
                ['top'=>'from-purple-400 to-purple-600','badge-bg'=>'bg-purple-50','badge-text'=>'text-purple-600'],
                ['top'=>'from-teal-400 to-teal-600',   'badge-bg'=>'bg-teal-50',   'badge-text'=>'text-teal-600'],
                ['top'=>'from-orange-400 to-orange-500','badge-bg'=>'bg-orange-50','badge-text'=>'text-orange-600'],
                ['top'=>'from-pink-400 to-pink-600',   'badge-bg'=>'bg-pink-50',   'badge-text'=>'text-pink-600'],
                ['top'=>'from-green-400 to-green-600', 'badge-bg'=>'bg-green-50',  'badge-text'=>'text-green-600'],
            ];
        @endphp
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach($items as $i => $item)
                @php $c = $cardColors[$i % 6]; @endphp
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group">
                    {{-- Image with gradient overlay --}}
                    <div class="relative h-44 overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br {{ $c['top'] }} opacity-20"></div>
                        <img src="{{ $item->photo_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute top-3 left-3">{!! $item->status_badge !!}</div>
                        @if(Auth::user()->isDonatur() && $item->user_id === Auth::id())
                            <div class="absolute top-3 right-3 flex gap-1 opacity-0 group-hover:opacity-100 transition">
                                <a href="{{ route('donations.edit', $item) }}" class="w-7 h-7 bg-white rounded-lg flex items-center justify-center text-blue-600 hover:bg-blue-50 shadow-sm text-xs">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <form method="POST" action="{{ route('donations.destroy', $item) }}" onsubmit="return confirm('Hapus barang ini?')">
                                    @csrf @method('DELETE')
                                    <button class="w-7 h-7 bg-white rounded-lg flex items-center justify-center text-red-500 hover:bg-red-50 shadow-sm text-xs">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <span class="inline-block text-xs font-bold px-2.5 py-1 rounded-lg mb-2 {{ $c['badge-bg'] }} {{ $c['badge-text'] }}">
                            {{ $item->category->name }}
                        </span>
                        <h3 class="font-bold text-gray-900 text-sm mb-1 line-clamp-1">{{ $item->title }}</h3>
                        <p class="text-xs text-gray-400 line-clamp-2 mb-3">{{ $item->description }}</p>
                        <div class="flex items-center justify-between text-xs text-gray-400 mb-3">
                            <span class="flex items-center gap-1"><i class="fa-solid fa-location-dot text-red-400"></i>{{ Str::limit($item->location, 18) }}</span>
                            <span class="flex items-center gap-1"><i class="fa-solid fa-layer-group text-blue-400"></i>{{ $item->quantity }} pcs</span>
                        </div>
                        <div class="pt-3 border-t border-gray-100">
                            @if(!Auth::user()->isDonatur())
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-400">oleh {{ $item->user->name }}</span>
                                    <a href="{{ route('donations.show', $item) }}"
                                       class="text-xs font-bold px-3 py-1.5 rounded-lg bg-gradient-to-r {{ $c['top'] }} text-white hover:shadow-sm transition">
                                        Lihat →
                                    </a>
                                </div>
                            @else
                                <a href="{{ route('donations.show', $item) }}"
                                   class="block text-center text-xs font-bold py-1.5 rounded-lg bg-gradient-to-r {{ $c['top'] }} text-white hover:shadow-sm transition">
                                    Lihat Detail →
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-2">{{ $items->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
