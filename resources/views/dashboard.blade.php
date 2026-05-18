@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang, ' . Auth::user()->name . '! 👋')

@section('content')
<div class="pt-2 space-y-6">

    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
        @php
            $statCards = [];
            if(Auth::user()->isDonatur()) {
                $statCards = [
                    ['label'=>'Total Barang', 'value'=>$stats['total_barang'], 'icon'=>'fa-box-open', 'from'=>'from-green-400', 'to'=>'to-green-600', 'link'=>route('donations.index')],
                    ['label'=>'Barang Tersedia', 'value'=>$stats['tersedia'], 'icon'=>'fa-circle-check', 'from'=>'from-blue-400', 'to'=>'to-blue-600', 'link'=>route('donations.index',['status'=>'tersedia'])],
                    ['label'=>'Klaim Pending', 'value'=>$stats['pending_klaim'], 'icon'=>'fa-clock', 'from'=>'from-amber-400', 'to'=>'to-orange-500', 'link'=>route('requests.index')],
                    ['label'=>'Donasi Selesai', 'value'=>$stats['selesai'], 'icon'=>'fa-heart', 'from'=>'from-pink-400', 'to'=>'to-rose-600', 'link'=>route('history.index')],
                ];
            } elseif(Auth::user()->isPenerima()) {
                $statCards = [
                    ['label'=>'Total Pengajuan', 'value'=>$stats['pengajuan'], 'icon'=>'fa-clipboard-list', 'from'=>'from-green-400', 'to'=>'to-green-600', 'link'=>route('requests.index')],
                    ['label'=>'Menunggu', 'value'=>$stats['pending'], 'icon'=>'fa-clock', 'from'=>'from-amber-400', 'to'=>'to-orange-500', 'link'=>route('requests.index')],
                    ['label'=>'Disetujui', 'value'=>$stats['disetujui'], 'icon'=>'fa-circle-check', 'from'=>'from-blue-400', 'to'=>'to-blue-600', 'link'=>route('requests.index')],
                    ['label'=>'Barang Tersedia', 'value'=>$stats['tersedia'], 'icon'=>'fa-box-open', 'from'=>'from-purple-400', 'to'=>'to-purple-600', 'link'=>route('donations.index')],
                ];
            } else {
                $statCards = [
                    ['label'=>'Total Pengguna', 'value'=>$stats['total_user'], 'icon'=>'fa-users', 'from'=>'from-green-400', 'to'=>'to-green-600', 'link'=>'#'],
                    ['label'=>'Total Barang', 'value'=>$stats['total_barang'], 'icon'=>'fa-box-open', 'from'=>'from-blue-400', 'to'=>'to-blue-600', 'link'=>route('donations.index')],
                    ['label'=>'Kategori', 'value'=>$stats['total_kategori'], 'icon'=>'fa-tags', 'from'=>'from-amber-400', 'to'=>'to-orange-500', 'link'=>route('categories.index')],
                    ['label'=>'Total Donasi', 'value'=>$stats['total_donasi'], 'icon'=>'fa-heart', 'from'=>'from-pink-400', 'to'=>'to-rose-600', 'link'=>route('history.index')],
                ];
            }
        @endphp

        @foreach($statCards as $card)
            <a href="{{ $card['link'] }}"
               class="relative overflow-hidden rounded-2xl p-5 bg-gradient-to-br {{ $card['from'] }} {{ $card['to'] }} shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 group">
                {{-- Background decoration --}}
                <div class="absolute -right-4 -top-4 w-20 h-20 bg-white/10 rounded-full"></div>
                <div class="absolute -right-2 -bottom-6 w-28 h-28 bg-white/10 rounded-full"></div>

                <div class="relative z-10">
                    <div class="w-11 h-11 bg-white/20 rounded-xl flex items-center justify-center mb-4 group-hover:bg-white/30 transition">
                        <i class="fa-solid {{ $card['icon'] }} text-white text-base"></i>
                    </div>
                    <div class="text-4xl font-extrabold text-white mb-1">{{ $card['value'] }}</div>
                    <div class="text-white/80 text-xs font-semibold">{{ $card['label'] }}</div>
                </div>
            </a>
        @endforeach
    </div>

    {{-- Kategori --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h3 class="font-bold text-gray-900 text-base">Kategori Barang</h3>
                <p class="text-xs text-gray-400 mt-0.5">Telusuri barang berdasarkan kategori</p>
            </div>
            <a href="{{ route('categories.index') }}"
               class="text-xs bg-green-50 text-green-600 hover:bg-green-100 font-semibold px-3 py-1.5 rounded-lg transition">
                Lihat semua →
            </a>
        </div>

        @php
            $catColors = [
                'Pakaian'    => ['bg'=>'bg-blue-50',   'icon-bg'=>'bg-blue-100',   'text'=>'text-blue-600',   'hover'=>'hover:bg-blue-50',   'emoji'=>'👕'],
                'Elektronik' => ['bg'=>'bg-purple-50', 'icon-bg'=>'bg-purple-100', 'text'=>'text-purple-600', 'hover'=>'hover:bg-purple-50', 'emoji'=>'📱'],
                'Buku'       => ['bg'=>'bg-amber-50',  'icon-bg'=>'bg-amber-100',  'text'=>'text-amber-600',  'hover'=>'hover:bg-amber-50',  'emoji'=>'📚'],
                'Perabot'    => ['bg'=>'bg-orange-50', 'icon-bg'=>'bg-orange-100', 'text'=>'text-orange-600', 'hover'=>'hover:bg-orange-50', 'emoji'=>'🪑'],
                'Mainan'     => ['bg'=>'bg-pink-50',   'icon-bg'=>'bg-pink-100',   'text'=>'text-pink-600',   'hover'=>'hover:bg-pink-50',   'emoji'=>'🧸'],
                'Makanan'    => ['bg'=>'bg-green-50',  'icon-bg'=>'bg-green-100',  'text'=>'text-green-600',  'hover'=>'hover:bg-green-50',  'emoji'=>'🍱'],
                'Olahraga'   => ['bg'=>'bg-teal-50',   'icon-bg'=>'bg-teal-100',   'text'=>'text-teal-600',   'hover'=>'hover:bg-teal-50',   'emoji'=>'⚽'],
                'Lainnya'    => ['bg'=>'bg-gray-50',   'icon-bg'=>'bg-gray-100',   'text'=>'text-gray-600',   'hover'=>'hover:bg-gray-100',  'emoji'=>'📦'],
            ];
        @endphp

        <div class="grid grid-cols-4 sm:grid-cols-4 lg:grid-cols-8 gap-3">
            @forelse($categories as $cat)
                @php $c = $catColors[$cat->name] ?? $catColors['Lainnya']; @endphp
                <a href="{{ route('donations.index', ['category_id' => $cat->id]) }}"
                   class="flex flex-col items-center gap-2 p-3 rounded-xl border-2 border-transparent {{ $c['bg'] }} hover:border-current {{ $c['text'] }} hover:shadow-sm transition-all group">
                    <div class="w-10 h-10 {{ $c['icon-bg'] }} rounded-xl flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                        {{ $c['emoji'] }}
                    </div>
                    <div class="text-[11px] font-bold {{ $c['text'] }} text-center leading-tight">{{ $cat->name }}</div>
                    <div class="text-[10px] text-gray-400 font-medium">{{ $cat->donation_items_count }} item</div>
                </a>
            @empty
                <div class="col-span-full text-center text-gray-400 text-sm py-4">Belum ada kategori.</div>
            @endforelse
        </div>
    </div>

    {{-- Recent Items --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h3 class="font-bold text-gray-900 text-base">
                    {{ Auth::user()->isDonatur() ? 'Barang Saya Terbaru' : 'Barang Tersedia Terbaru' }}
                </h3>
                <p class="text-xs text-gray-400 mt-0.5">
                    {{ Auth::user()->isDonatur() ? 'Barang donasi yang baru kamu posting' : 'Barang yang baru tersedia untuk diklaim' }}
                </p>
            </div>
            <a href="{{ route('donations.index') }}"
               class="text-xs bg-green-50 text-green-600 hover:bg-green-100 font-semibold px-3 py-1.5 rounded-lg transition">
                Lihat semua →
            </a>
        </div>

        @php
            $itemColors = ['green','blue','purple','orange','pink','teal'];
            $itemBg = ['bg-green-50','bg-blue-50','bg-purple-50','bg-orange-50','bg-pink-50','bg-teal-50'];
            $itemBorder = ['border-green-200','border-blue-200','border-purple-200','border-orange-200','border-pink-200','border-teal-200'];
            $itemHover = ['hover:bg-green-50','hover:bg-blue-50','hover:bg-purple-50','hover:bg-orange-50','hover:bg-pink-50','hover:bg-teal-50'];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($recentItems as $i => $item)
                @php $ci = $i % 6; @endphp
                <a href="{{ route('donations.show', $item) }}"
                   class="flex items-center gap-3 p-3.5 rounded-xl border-2 {{ $itemBorder[$ci] }} {{ $itemHover[$ci] }} bg-white hover:shadow-sm transition-all group">
                    <div class="w-14 h-14 rounded-xl overflow-hidden flex-shrink-0 {{ $itemBg[$ci] }}">
                        <img src="{{ $item->photo_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-bold text-sm text-gray-900 truncate group-hover:text-green-700 transition">{{ $item->title }}</div>
                        <div class="text-xs text-gray-400 mt-0.5 mb-1.5">{{ $item->category->name }}</div>
                        <div>{!! $item->status_badge !!}</div>
                    </div>
                    <i class="fa-solid fa-chevron-right text-gray-300 text-xs group-hover:text-green-500 group-hover:translate-x-0.5 transition-all flex-shrink-0"></i>
                </a>
            @empty
                <div class="col-span-full text-center py-10">
                    <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                        <i class="fa-solid fa-box-open text-gray-300 text-2xl"></i>
                    </div>
                    <p class="text-gray-400 text-sm font-medium">Belum ada barang.</p>
                    @if(Auth::user()->isDonatur())
                        <a href="{{ route('donations.create') }}"
                           class="mt-3 inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition">
                            <i class="fa-solid fa-plus text-xs"></i> Tambah Barang
                        </a>
                    @endif
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
