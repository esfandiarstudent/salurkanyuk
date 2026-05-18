@extends('layouts.app')
@section('title', 'Tambah Kategori')
@section('page-title', 'Tambah Kategori')
@section('page-subtitle', 'Tambah kategori barang baru')

@section('header-action')
    <a href="{{ route('categories.index') }}" class="btn-secondary"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
@endsection

@section('content')
<div class="pt-2 max-w-lg">
    <div class="card p-8">
        <form method="POST" action="{{ route('categories.store') }}" class="space-y-5">
            @csrf
            <div>
                <label class="form-label">Nama Kategori <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-input" placeholder="cth: Pakaian" required>
            </div>
            <div>
                <label class="form-label">Ikon (opsional)</label>
                <input type="text" name="icon" value="{{ old('icon') }}" class="form-input" placeholder="cth: 👕 atau fa-shirt">
                <p class="text-xs text-gray-400 mt-1">Gunakan emoji atau nama ikon Font Awesome</p>
            </div>
            <div>
                <label class="form-label">Deskripsi</label>
                <textarea name="description" rows="3" class="form-input resize-none" placeholder="Deskripsi singkat kategori...">{{ old('description') }}</textarea>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary flex-1 justify-center py-3">
                    <i class="fa-solid fa-plus"></i> Tambah Kategori
                </button>
                <a href="{{ route('categories.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
