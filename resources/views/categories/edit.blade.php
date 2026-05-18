@extends('layouts.app')
@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')
@section('page-subtitle', $category->name)

@section('header-action')
    <a href="{{ route('categories.index') }}" class="btn-secondary"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
@endsection

@section('content')
<div class="pt-2 max-w-lg">
    <div class="card p-8">
        <form method="POST" action="{{ route('categories.update', $category) }}" class="space-y-5">
            @csrf @method('PUT')
            <div>
                <label class="form-label">Nama Kategori</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" class="form-input" required>
            </div>
            <div>
                <label class="form-label">Ikon</label>
                <input type="text" name="icon" value="{{ old('icon', $category->icon) }}" class="form-input">
            </div>
            <div>
                <label class="form-label">Deskripsi</label>
                <textarea name="description" rows="3" class="form-input resize-none">{{ old('description', $category->description) }}</textarea>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary flex-1 justify-center py-3">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                </button>
                <a href="{{ route('categories.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
