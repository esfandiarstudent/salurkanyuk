@extends('layouts.app')
@section('title', 'Tambah Barang Donasi')
@section('page-title', 'Tambah Barang Donasi')
@section('page-subtitle', 'Isi detail barang yang ingin Anda donasikan')

@section('header-action')
    <a href="{{ route('donations.index') }}" class="btn-secondary">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
@endsection

@section('content')
<div class="pt-2 max-w-2xl">
    <div class="card p-8">
        <form method="POST" action="{{ route('donations.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Photo Upload --}}
            <div>
                <label class="form-label">Foto Barang</label>
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-green-300 transition cursor-pointer relative" id="dropzone">
                    <input type="file" name="photo" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full" id="photoInput" onchange="previewPhoto(this)">
                    <div id="preview-placeholder">
                        <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <i class="fa-solid fa-cloud-arrow-up text-green-400 text-xl"></i>
                        </div>
                        <p class="text-sm font-semibold text-gray-700">Klik atau drag foto ke sini</p>
                        <p class="text-xs text-gray-400 mt-1">PNG, JPG, WEBP — maks. 2MB</p>
                    </div>
                    <img id="photo-preview" src="" alt="" class="hidden max-h-48 mx-auto rounded-lg object-cover">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-5">
                <div class="col-span-2">
                    <label class="form-label">Judul Barang <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" class="form-input" placeholder="cth: Baju Anak Usia 5-7 Tahun" required>
                </div>
                <div>
                    <label class="form-label">Kategori <span class="text-red-500">*</span></label>
                    <select name="category_id" class="form-input" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Jumlah (pcs) <span class="text-red-500">*</span></label>
                    <input type="number" name="quantity" value="{{ old('quantity', 1) }}" min="1" class="form-input" required>
                </div>
                <div class="col-span-2">
                    <label class="form-label">Deskripsi Barang <span class="text-red-500">*</span></label>
                    <textarea name="description" rows="4" class="form-input resize-none" placeholder="Jelaskan kondisi barang secara detail..." required>{{ old('description') }}</textarea>
                </div>
                <div class="col-span-2">
                    <label class="form-label">Lokasi Pengambilan <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fa-solid fa-location-dot absolute left-3.5 top-3 text-gray-400 text-sm"></i>
                        <input type="text" name="location" value="{{ old('location') }}" class="form-input pl-10" placeholder="cth: Jl. Malang Indah No. 10, Kota Malang" required>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary flex-1 justify-center py-3">
                    <i class="fa-solid fa-paper-plane"></i> Posting Barang Donasi
                </button>
                <a href="{{ route('donations.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewPhoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('preview-placeholder').classList.add('hidden');
            const img = document.getElementById('photo-preview');
            img.src = e.target.result;
            img.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
