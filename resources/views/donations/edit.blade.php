@extends('layouts.app')
@section('title', 'Edit Barang')
@section('page-title', 'Edit Barang Donasi')
@section('page-subtitle', $donation->title)

@section('header-action')
    <a href="{{ route('donations.show', $donation) }}" class="btn-secondary">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
@endsection

@section('content')
<div class="pt-2 max-w-2xl">
    <div class="card p-8">
        <form method="POST" action="{{ route('donations.update', $donation) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf @method('PUT')

            <div>
                <label class="form-label">Foto Barang</label>
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-4 text-center hover:border-green-300 transition cursor-pointer relative">
                    <input type="file" name="photo" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full" onchange="previewPhoto(this)">
                    <img id="photo-preview" src="{{ $donation->photo_url }}" alt="" class="max-h-40 mx-auto rounded-lg object-cover">
                    <p class="text-xs text-gray-400 mt-2">Klik untuk ganti foto</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-5">
                <div class="col-span-2">
                    <label class="form-label">Judul Barang</label>
                    <input type="text" name="title" value="{{ old('title', $donation->title) }}" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Kategori</label>
                    <select name="category_id" class="form-input" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $donation->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="quantity" value="{{ old('quantity', $donation->quantity) }}" min="1" class="form-input" required>
                </div>
                <div class="col-span-2">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" rows="4" class="form-input resize-none" required>{{ old('description', $donation->description) }}</textarea>
                </div>
                <div class="col-span-2">
                    <label class="form-label">Lokasi</label>
                    <div class="relative">
                        <i class="fa-solid fa-location-dot absolute left-3.5 top-3 text-gray-400 text-sm"></i>
                        <input type="text" name="location" value="{{ old('location', $donation->location) }}" class="form-input pl-10" required>
                    </div>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="btn-primary flex-1 justify-center py-3">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                </button>
                <a href="{{ route('donations.show', $donation) }}" class="btn-secondary">Batal</a>
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
        reader.onload = e => document.getElementById('photo-preview').src = e.target.result;
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
