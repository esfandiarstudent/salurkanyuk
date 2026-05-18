@extends('layouts.app')
@section('title', $donation->title)
@section('page-title', 'Detail Barang')
@section('page-subtitle', $donation->title)

@section('header-action')
    <a href="{{ route('donations.index') }}" class="btn-secondary">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
@endsection

@section('content')
<div class="pt-2 grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Left: Foto + Info --}}
    <div class="lg:col-span-2 space-y-5">
        <div class="card overflow-hidden">
            <div class="h-72 bg-gray-100 overflow-hidden">
                <img src="{{ $donation->photo_url }}" alt="{{ $donation->title }}" class="w-full h-full object-cover">
            </div>
            <div class="p-6">
                <div class="flex items-start justify-between gap-4 mb-4">
                    <div>
                        <span class="text-xs font-semibold text-green-600 bg-green-50 px-2.5 py-1 rounded-lg">{{ $donation->category->name }}</span>
                        <h2 class="text-2xl font-bold text-gray-900 mt-2">{{ $donation->title }}</h2>
                    </div>
                    <div>{!! $donation->status_badge !!}</div>
                </div>
                <p class="text-gray-600 text-sm leading-relaxed mb-5">{{ $donation->description }}</p>
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex items-center gap-2.5 text-sm text-gray-600">
                        <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center text-green-500">
                            <i class="fa-solid fa-location-dot text-xs"></i>
                        </div>
                        <div>
                            <div class="text-[10px] text-gray-400 font-medium uppercase tracking-wide">Lokasi</div>
                            <div class="font-semibold text-gray-800">{{ $donation->location }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2.5 text-sm text-gray-600">
                        <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center text-blue-500">
                            <i class="fa-solid fa-layer-group text-xs"></i>
                        </div>
                        <div>
                            <div class="text-[10px] text-gray-400 font-medium uppercase tracking-wide">Jumlah</div>
                            <div class="font-semibold text-gray-800">{{ $donation->quantity }} pcs</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2.5 text-sm text-gray-600">
                        <div class="w-8 h-8 bg-purple-50 rounded-lg flex items-center justify-center text-purple-500">
                            <i class="fa-solid fa-user text-xs"></i>
                        </div>
                        <div>
                            <div class="text-[10px] text-gray-400 font-medium uppercase tracking-wide">Donatur</div>
                            <div class="font-semibold text-gray-800">{{ $donation->user->name }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2.5 text-sm text-gray-600">
                        <div class="w-8 h-8 bg-amber-50 rounded-lg flex items-center justify-center text-amber-500">
                            <i class="fa-solid fa-calendar text-xs"></i>
                        </div>
                        <div>
                            <div class="text-[10px] text-gray-400 font-medium uppercase tracking-wide">Diposting</div>
                            <div class="font-semibold text-gray-800">{{ $donation->created_at->format('d M Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pengajuan klaim (untuk donatur) --}}
        @if(Auth::user()->isDonatur() && $donation->user_id === Auth::id())
            <div class="card p-6">
                <h3 class="font-bold text-gray-900 mb-4">Pengajuan Klaim ({{ $donation->requests->count() }})</h3>
                @forelse($donation->requests as $req)
                    <div class="flex items-start gap-4 p-4 rounded-xl border border-gray-100 hover:bg-gray-50 mb-3 last:mb-0">
                        <img src="{{ $req->user->photo_url }}" class="w-10 h-10 rounded-xl object-cover flex-shrink-0">
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-semibold text-sm text-gray-900">{{ $req->user->name }}</span>
                                <div>{!! $req->status_badge !!}</div>
                            </div>
                            <p class="text-xs text-gray-600 mb-3">{{ $req->message }}</p>
                            @if($req->status === 'pending' && $donation->status === 'tersedia')
                                <div class="flex gap-2">
                                    <form method="POST" action="{{ route('requests.approve', $req) }}">
                                        @csrf
                                        <button class="btn-primary py-1.5 px-3 text-xs">
                                            <i class="fa-solid fa-check"></i> Setujui
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('requests.reject', $req) }}">
                                        @csrf
                                        <button class="btn-danger py-1.5 px-3 text-xs">
                                            <i class="fa-solid fa-xmark"></i> Tolak
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-400">
                        <i class="fa-solid fa-inbox text-3xl mb-2 block"></i>
                        <p class="text-sm">Belum ada pengajuan klaim.</p>
                    </div>
                @endforelse
            </div>
        @endif
    </div>

    {{-- Right: Action panel --}}
    <div class="space-y-5">
        {{-- Klaim (penerima) --}}
        @if(Auth::user()->isPenerima())
            <div class="card p-6">
                <h3 class="font-bold text-gray-900 mb-4">Ajukan Klaim</h3>
                @if($donation->status !== 'tersedia')
                    <div class="bg-gray-50 rounded-xl p-4 text-center">
                        <i class="fa-solid fa-ban text-gray-300 text-3xl mb-2 block"></i>
                        <p class="text-sm text-gray-500">Barang ini sudah tidak tersedia.</p>
                    </div>
                @elseif($userRequest)
                    <div class="bg-{{ $userRequest->status === 'disetujui' ? 'green' : ($userRequest->status === 'ditolak' ? 'red' : 'yellow') }}-50 border border-{{ $userRequest->status === 'disetujui' ? 'green' : ($userRequest->status === 'ditolak' ? 'red' : 'yellow') }}-200 rounded-xl p-4 text-center">
                        <div class="text-2xl mb-2">{{ $userRequest->status === 'disetujui' ? '🎉' : ($userRequest->status === 'ditolak' ? '😔' : '⏳') }}</div>
                        <p class="text-sm font-semibold">Status Pengajuan Anda</p>
                        <div class="mt-1">{!! $userRequest->status_badge !!}</div>
                    </div>
                @else
                    <form method="POST" action="{{ route('requests.store') }}" class="space-y-4">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $donation->id }}">
                        <div>
                            <label class="form-label">Alasan Pengajuan <span class="text-red-500">*</span></label>
                            <textarea name="message" rows="5" class="form-input resize-none" placeholder="Jelaskan mengapa Anda membutuhkan barang ini... (min. 20 karakter)" required minlength="20">{{ old('message') }}</textarea>
                        </div>
                        <button type="submit" class="btn-primary w-full justify-center py-3">
                            <i class="fa-solid fa-paper-plane"></i> Kirim Pengajuan
                        </button>
                    </form>
                @endif
            </div>
        @endif

        {{-- Donatur actions --}}
        @if(Auth::user()->isDonatur() && $donation->user_id === Auth::id())
            <div class="card p-6">
                <h3 class="font-bold text-gray-900 mb-4">Kelola Barang</h3>
                <div class="space-y-3">
                    <a href="{{ route('donations.edit', $donation) }}" class="btn-secondary w-full justify-center">
                        <i class="fa-solid fa-pen"></i> Edit Barang
                    </a>
                    <form method="POST" action="{{ route('donations.destroy', $donation) }}" onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                        @csrf @method('DELETE')
                        <button class="btn-danger w-full justify-center">
                            <i class="fa-solid fa-trash"></i> Hapus Barang
                        </button>
                    </form>
                </div>
            </div>
        @endif

        {{-- Info donatur --}}
        <div class="card p-6">
            <h3 class="font-bold text-gray-900 mb-4">Info Donatur</h3>
            <div class="flex items-center gap-3 mb-4">
                <img src="{{ $donation->user->photo_url }}" class="w-12 h-12 rounded-xl object-cover">
                <div>
                    <div class="font-semibold text-gray-900">{{ $donation->user->name }}</div>
                    <div class="text-xs text-green-600 font-medium">Donatur Aktif</div>
                </div>
            </div>
            @if($donation->user->phone)
                <div class="text-sm text-gray-600"><i class="fa-solid fa-phone mr-2 text-gray-400"></i>{{ $donation->user->phone }}</div>
            @endif
            @if($donation->user->address)
                <div class="text-sm text-gray-600 mt-2"><i class="fa-solid fa-location-dot mr-2 text-gray-400"></i>{{ Str::limit($donation->user->address, 50) }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
