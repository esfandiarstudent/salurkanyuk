@extends('layouts.app')
@section('title','Kategori')
@section('page-title','Kategori Barang')
@section('page-subtitle','Daftar semua kategori barang donasi')

@section('header-action')
    @if(Auth::user()->isAdmin())
        <a href="{{ route('categories.create') }}"
           class="inline-flex items-center gap-2 bg-gradient-to-r from-orange-400 to-orange-600 hover:from-orange-500 hover:to-orange-700 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition-all shadow-sm">
            <i class="fa-solid fa-plus"></i> Tambah Kategori
        </a>
    @endif
@endsection

@section('content')
<div class="pt-2">
    @php
        $catStyles = [
            'Pakaian'    => ['grad'=>'from-blue-400 to-blue-600',     'light'=>'bg-blue-50',   'text'=>'text-blue-600',   'emoji'=>'👕'],
            'Elektronik' => ['grad'=>'from-purple-400 to-purple-600', 'light'=>'bg-purple-50', 'text'=>'text-purple-600', 'emoji'=>'📱'],
            'Buku'       => ['grad'=>'from-amber-400 to-amber-600',   'light'=>'bg-amber-50',  'text'=>'text-amber-600',  'emoji'=>'📚'],
            'Perabot'    => ['grad'=>'from-orange-400 to-orange-600', 'light'=>'bg-orange-50', 'text'=>'text-orange-600', 'emoji'=>'🪑'],
            'Mainan'     => ['grad'=>'from-pink-400 to-pink-600',     'light'=>'bg-pink-50',   'text'=>'text-pink-600',   'emoji'=>'🧸'],
            'Makanan'    => ['grad'=>'from-green-400 to-green-600',   'light'=>'bg-green-50',  'text'=>'text-green-600',  'emoji'=>'🍱'],
            'Olahraga'   => ['grad'=>'from-teal-400 to-teal-600',     'light'=>'bg-teal-50',   'text'=>'text-teal-600',   'emoji'=>'⚽'],
            'Lainnya'    => ['grad'=>'from-gray-400 to-gray-600',     'light'=>'bg-gray-50',   'text'=>'text-gray-600',   'emoji'=>'📦'],
        ];
        $fallback = ['grad'=>'from-green-400 to-green-600','light'=>'bg-green-50','text'=>'text-green-600','emoji'=>'📦'];
    @endphp

    @if($categories->isEmpty())
        <div class="bg-white rounded-2xl p-16 text-center shadow-sm border border-gray-100">
            <div class="text-6xl mb-4">🏷️</div>
            <h3 class="font-bold text-gray-900 text-xl mb-2">Belum ada kategori</h3>
            <p class="text-gray-400 text-sm">Admin belum menambahkan kategori barang.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach($categories as $cat)
                @php $s = $catStyles[$cat->name] ?? $fallback; @endphp
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group">
                    {{-- Gradient header --}}
                    <div class="h-24 bg-gradient-to-br {{ $s['grad'] }} relative flex items-center justify-center overflow-hidden">
                        <div class="absolute -right-4 -top-4 w-20 h-20 bg-white/10 rounded-full"></div>
                        <div class="absolute -left-4 -bottom-4 w-16 h-16 bg-white/10 rounded-full"></div>
                        <span class="text-5xl relative z-10 group-hover:scale-110 transition-transform duration-200">{{ $s['emoji'] }}</span>
                        @if(Auth::user()->isAdmin())
                            <div class="absolute top-2 right-2 flex gap-1 opacity-0 group-hover:opacity-100 transition">
                                <a href="{{ route('categories.edit', $cat) }}"
                                   class="w-7 h-7 bg-white/90 rounded-lg flex items-center justify-center text-blue-600 hover:bg-white shadow-sm text-xs">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <form method="POST" action="{{ route('categories.destroy', $cat) }}" onsubmit="return confirm('Hapus kategori ini?')">
                                    @csrf @method('DELETE')
                                    <button class="w-7 h-7 bg-white/90 rounded-lg flex items-center justify-center text-red-500 hover:bg-white shadow-sm text-xs">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                    <div class="p-5">
                        <h3 class="font-bold text-gray-900 text-base mb-1">{{ $cat->name }}</h3>
                        @if($cat->description)
                            <p class="text-xs text-gray-500 mb-4 line-clamp-2">{{ $cat->description }}</p>
                        @endif
                        <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-100">
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold {{ $s['light'] }} {{ $s['text'] }} px-2.5 py-1.5 rounded-lg">
                                <i class="fa-solid fa-box-open text-[10px]"></i>
                                {{ $cat->donation_items_count }} barang
                            </span>
                            <a href="{{ route('donations.index', ['category_id' => $cat->id]) }}"
                               class="inline-flex items-center gap-1.5 text-xs font-bold text-white bg-gradient-to-r {{ $s['grad'] }} px-3 py-1.5 rounded-lg hover:shadow-sm transition">
                                Lihat <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $categories->links() }}</div>
    @endif
</div>
@endsection
