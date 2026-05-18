@extends('layouts.app')
@section('title','Pengajuan Klaim')
@section('page-title','Pengajuan Klaim')
@section('page-subtitle', Auth::user()->isDonatur() ? 'Permintaan klaim barang Anda' : 'Riwayat pengajuan klaim Anda')

@section('content')
<div class="pt-2 space-y-4">

    {{-- Summary Stats --}}
    @if(!$requests->isEmpty())
    <div class="grid grid-cols-3 gap-4 mb-2">
        @php
            $all = $requests->total();
            $pending   = $requests->getCollection()->where('status','pending')->count();
            $disetujui = $requests->getCollection()->where('status','disetujui')->count();
            $ditolak   = $requests->getCollection()->where('status','ditolak')->count();
        @endphp
        <div class="relative overflow-hidden rounded-2xl p-4 bg-gradient-to-br from-amber-400 to-orange-500 shadow-md">
            <div class="absolute -right-3 -top-3 w-14 h-14 bg-white/10 rounded-full"></div>
            <div class="text-2xl font-extrabold text-white">{{ $requests->total() }}</div>
            <div class="text-white/80 text-xs font-semibold mt-1">Total Pengajuan</div>
        </div>
        <div class="relative overflow-hidden rounded-2xl p-4 bg-gradient-to-br from-green-400 to-green-600 shadow-md">
            <div class="absolute -right-3 -top-3 w-14 h-14 bg-white/10 rounded-full"></div>
            <div class="text-2xl font-extrabold text-white">{{ $disetujui }}</div>
            <div class="text-white/80 text-xs font-semibold mt-1">Disetujui</div>
        </div>
        <div class="relative overflow-hidden rounded-2xl p-4 bg-gradient-to-br from-red-400 to-rose-600 shadow-md">
            <div class="absolute -right-3 -top-3 w-14 h-14 bg-white/10 rounded-full"></div>
            <div class="text-2xl font-extrabold text-white">{{ $ditolak }}</div>
            <div class="text-white/80 text-xs font-semibold mt-1">Ditolak</div>
        </div>
    </div>
    @endif

    @if($requests->isEmpty())
        <div class="bg-white rounded-2xl p-16 text-center shadow-sm border border-gray-100">
            <div class="w-20 h-20 bg-purple-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-clipboard-list text-purple-300 text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Belum ada pengajuan</h3>
            <p class="text-gray-400 text-sm mb-5">
                @if(Auth::user()->isPenerima()) Anda belum mengajukan klaim barang apapun. @else Belum ada penerima yang mengajukan klaim. @endif
            </p>
            @if(Auth::user()->isPenerima())
                <a href="{{ route('donations.index') }}"
                   class="inline-flex items-center gap-2 bg-gradient-to-r from-purple-500 to-purple-600 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition shadow-sm">
                    <i class="fa-solid fa-search"></i> Cari Barang Donasi
                </a>
            @endif
        </div>
    @else
        <div class="space-y-3">
            @foreach($requests as $i => $req)
                @php
                    $colors = [
                        'pending'   => ['border'=>'border-l-amber-400',  'bg'=>'bg-amber-50',   'text'=>'text-amber-700',  'icon'=>'fa-clock',       'badge'=>'bg-amber-100 text-amber-700'],
                        'disetujui' => ['border'=>'border-l-green-400',  'bg'=>'bg-green-50',   'text'=>'text-green-700',  'icon'=>'fa-circle-check','badge'=>'bg-green-100 text-green-700'],
                        'ditolak'   => ['border'=>'border-l-red-400',    'bg'=>'bg-red-50',     'text'=>'text-red-700',    'icon'=>'fa-circle-xmark','badge'=>'bg-red-100 text-red-700'],
                    ];
                    $c = $colors[$req->status] ?? $colors['pending'];
                @endphp
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 border-l-4 {{ $c['border'] }} overflow-hidden hover:shadow-md transition-all">
                    <div class="p-5 flex items-start gap-4">
                        {{-- Item photo --}}
                        <div class="relative flex-shrink-0">
                            <div class="w-16 h-16 rounded-xl overflow-hidden bg-gray-100">
                                <img src="{{ $req->item->photo_url }}" class="w-full h-full object-cover">
                            </div>
                            <div class="absolute -bottom-1 -right-1 w-6 h-6 {{ $c['bg'] }} rounded-lg flex items-center justify-center {{ $c['text'] }}">
                                <i class="fa-solid {{ $c['icon'] }} text-[10px]"></i>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-3 flex-wrap">
                                <div>
                                    <h3 class="font-bold text-gray-900 text-sm">{{ Str::limit($req->item->title, 40) }}</h3>
                                    <div class="text-xs text-gray-400 mt-0.5">{{ $req->item->category->name }}</div>
                                </div>
                                <span class="text-xs font-bold px-2.5 py-1 rounded-full {{ $c['badge'] }} capitalize flex-shrink-0">
                                    {{ $req->status }}
                                </span>
                            </div>

                            {{-- Pesan --}}
                            <div class="mt-2 px-3 py-2 bg-gray-50 rounded-xl">
                                <p class="text-xs text-gray-500 italic">"{{ Str::limit($req->message, 100) }}"</p>
                            </div>

                            {{-- Meta --}}
                            <div class="mt-3 flex items-center gap-4 flex-wrap">
                                @if(Auth::user()->isDonatur())
                                    <div class="flex items-center gap-2">
                                        <img src="{{ $req->user->photo_url }}" class="w-6 h-6 rounded-lg object-cover">
                                        <span class="text-xs font-semibold text-gray-700">{{ $req->user->name }}</span>
                                        <span class="text-xs text-gray-400">(Pemohon)</span>
                                    </div>
                                @else
                                    <div class="flex items-center gap-1.5 text-xs text-gray-500">
                                        <i class="fa-solid fa-user text-gray-300"></i>
                                        <span class="font-semibold">{{ $req->item->user->name }}</span>
                                        <span class="text-gray-400">(Donatur)</span>
                                    </div>
                                @endif
                                <div class="flex items-center gap-1.5 text-xs text-gray-400">
                                    <i class="fa-solid fa-calendar"></i>
                                    {{ $req->created_at->format('d M Y') }}
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex flex-col gap-2 flex-shrink-0">
                            @if(Auth::user()->isDonatur() && $req->status === 'pending' && $req->item->status === 'tersedia')
                                <form method="POST" action="{{ route('requests.approve', $req) }}">
                                    @csrf
                                    <button class="w-full inline-flex items-center justify-center gap-1.5 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white text-xs font-bold px-4 py-2 rounded-xl transition shadow-sm">
                                        <i class="fa-solid fa-check"></i> Setujui
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('requests.reject', $req) }}">
                                    @csrf
                                    <button class="w-full inline-flex items-center justify-center gap-1.5 bg-gradient-to-r from-red-400 to-red-600 hover:from-red-500 hover:to-red-700 text-white text-xs font-bold px-4 py-2 rounded-xl transition shadow-sm">
                                        <i class="fa-solid fa-xmark"></i> Tolak
                                    </button>
                                </form>
                            @elseif(Auth::user()->isPenerima() && $req->status === 'pending')
                                <form method="POST" action="{{ route('requests.destroy', $req) }}" onsubmit="return confirm('Batalkan pengajuan ini?')">
                                    @csrf @method('DELETE')
                                    <button class="inline-flex items-center gap-1.5 bg-gradient-to-r from-red-400 to-red-600 hover:from-red-500 hover:to-red-700 text-white text-xs font-bold px-4 py-2 rounded-xl transition shadow-sm">
                                        <i class="fa-solid fa-ban"></i> Batalkan
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('donations.show', $req->item) }}"
                               class="inline-flex items-center justify-center gap-1.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold px-4 py-2 rounded-xl transition">
                                <i class="fa-solid fa-eye"></i> Lihat
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-5">{{ $requests->links() }}</div>
    @endif
</div>
@endsection
