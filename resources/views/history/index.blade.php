@extends('layouts.app')
@section('title','Riwayat Donasi')
@section('page-title','Riwayat Donasi')
@section('page-subtitle','Rekap seluruh riwayat donasi Anda')

@section('content')
<div class="pt-2 space-y-5">

    {{-- Filter --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <form method="GET" class="flex flex-wrap gap-3 items-end">
            <div class="min-w-[150px]">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Status</label>
                <select name="status" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-200 focus:border-teal-400 outline-none transition">
                    <option value="">Semua Status</option>
                    <option value="selesai"    {{ request('status')==='selesai'    ?'selected':'' }}>Selesai</option>
                    <option value="dibatalkan" {{ request('status')==='dibatalkan' ?'selected':'' }}>Dibatalkan</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Dari Tanggal</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}"
                    class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-200 focus:border-teal-400 outline-none transition">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Sampai Tanggal</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}"
                    class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-200 focus:border-teal-400 outline-none transition">
            </div>
            <button type="submit"
                class="inline-flex items-center gap-2 bg-gradient-to-r from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition shadow-sm">
                <i class="fa-solid fa-filter"></i> Filter
            </button>
            @if(request()->hasAny(['status','date_from','date_to']))
                <a href="{{ route('history.index') }}"
                   class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold px-5 py-2.5 rounded-xl text-sm transition">
                    <i class="fa-solid fa-xmark"></i> Reset
                </a>
            @endif
        </form>
    </div>

    @if($histories->isEmpty())
        <div class="bg-white rounded-2xl p-16 text-center shadow-sm border border-gray-100">
            <div class="w-20 h-20 bg-teal-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-clock-rotate-left text-teal-300 text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Belum ada riwayat</h3>
            <p class="text-gray-400 text-sm">Riwayat donasi akan muncul di sini setelah proses klaim selesai.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($histories as $i => $h)
                @php
                    $isSelesai = $h->status === 'selesai';
                    $borderColor = $isSelesai ? 'border-l-teal-400' : 'border-l-red-400';
                    $gradFrom   = $isSelesai ? 'from-teal-400'  : 'from-red-400';
                    $gradTo     = $isSelesai ? 'to-teal-600'    : 'to-red-600';
                    $bgLight    = $isSelesai ? 'bg-teal-50'     : 'bg-red-50';
                    $textColor  = $isSelesai ? 'text-teal-600'  : 'text-red-600';
                    $badgeCls   = $isSelesai ? 'bg-teal-100 text-teal-700' : 'bg-red-100 text-red-700';
                    $rowBgs = ['bg-blue-50','bg-purple-50','bg-green-50','bg-orange-50','bg-pink-50','bg-teal-50'];
                    $rowBg = $rowBgs[$i % 6];
                @endphp

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 border-l-4 {{ $borderColor }} overflow-hidden hover:shadow-md transition-all">
                    <div class="p-5 flex items-start gap-4">

                        {{-- Photo --}}
                        <div class="relative flex-shrink-0">
                            <div class="w-16 h-16 rounded-xl overflow-hidden">
                                <img src="{{ $h->item->photo_url }}" class="w-full h-full object-cover">
                            </div>
                            <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-gradient-to-br {{ $gradFrom }} {{ $gradTo }} rounded-lg flex items-center justify-center">
                                <i class="fa-solid {{ $isSelesai ? 'fa-check' : 'fa-ban' }} text-white text-[8px]"></i>
                            </div>
                        </div>

                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-3 flex-wrap">
                                <div>
                                    <h3 class="font-bold text-gray-900">{{ $h->item->title }}</h3>
                                    <span class="text-xs {{ $bgLight }} {{ $textColor }} font-semibold px-2 py-0.5 rounded-lg mt-1 inline-block">
                                        {{ $h->item->category->name }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-bold px-3 py-1 rounded-full {{ $badgeCls }} capitalize">
                                        {{ $h->status }}
                                    </span>
                                    @if(Auth::user()->isDonatur() && $h->status === 'selesai')
                                        <button onclick="document.getElementById('modal-{{ $h->id }}').classList.remove('hidden')"
                                            class="inline-flex items-center gap-1.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-xs font-bold px-3 py-1.5 rounded-xl transition shadow-sm">
                                            <i class="fa-solid fa-pen text-[10px]"></i> Update
                                        </button>
                                    @endif
                                </div>
                            </div>

                            {{-- Meta grid --}}
                            <div class="mt-3 grid grid-cols-2 sm:grid-cols-4 gap-3">
                                <div class="bg-blue-50 rounded-xl px-3 py-2">
                                    <div class="text-[10px] text-blue-400 font-bold uppercase tracking-wide">Donatur</div>
                                    <div class="text-xs font-bold text-gray-800 mt-0.5 truncate">{{ $h->donor->name }}</div>
                                </div>
                                <div class="bg-green-50 rounded-xl px-3 py-2">
                                    <div class="text-[10px] text-green-400 font-bold uppercase tracking-wide">Penerima</div>
                                    <div class="text-xs font-bold text-gray-800 mt-0.5 truncate">{{ $h->receiver->name }}</div>
                                </div>
                                <div class="bg-purple-50 rounded-xl px-3 py-2">
                                    <div class="text-[10px] text-purple-400 font-bold uppercase tracking-wide">Tanggal</div>
                                    <div class="text-xs font-bold text-gray-800 mt-0.5">{{ $h->completed_at ? $h->completed_at->format('d M Y') : '-' }}</div>
                                </div>
                                @if($h->note)
                                <div class="bg-orange-50 rounded-xl px-3 py-2">
                                    <div class="text-[10px] text-orange-400 font-bold uppercase tracking-wide">Catatan</div>
                                    <div class="text-xs font-bold text-gray-800 mt-0.5 truncate">{{ Str::limit($h->note, 30) }}</div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Modal Update Status --}}
                <div id="modal-{{ $h->id }}" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
                    <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-xl">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                                <i class="fa-solid fa-pen text-blue-500"></i>
                            </div>
                            <h3 class="font-bold text-gray-900 text-lg">Update Status Donasi</h3>
                        </div>
                        <form method="POST" action="{{ route('history.update', $h) }}" class="space-y-4">
                            @csrf @method('PUT')
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Status</label>
                                <select name="status" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-200 outline-none">
                                    <option value="selesai"    {{ $h->status==='selesai'    ?'selected':'' }}>✅ Selesai</option>
                                    <option value="dibatalkan" {{ $h->status==='dibatalkan' ?'selected':'' }}>❌ Dibatalkan</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Catatan Tambahan</label>
                                <textarea name="note" rows="3"
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-200 outline-none resize-none"
                                    placeholder="Tambahkan catatan...">{{ $h->note }}</textarea>
                            </div>
                            <div class="flex gap-3">
                                <button type="submit"
                                    class="flex-1 inline-flex items-center justify-center gap-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-2.5 rounded-xl text-sm transition shadow-sm">
                                    <i class="fa-solid fa-save"></i> Simpan
                                </button>
                                <button type="button" onclick="document.getElementById('modal-{{ $h->id }}').classList.add('hidden')"
                                    class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-5 py-2.5 rounded-xl text-sm transition">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-5">{{ $histories->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
