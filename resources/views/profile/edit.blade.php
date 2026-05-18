@extends('layouts.app')
@section('title', 'Edit Profil')
@section('page-title', 'Edit Profil')
@section('page-subtitle', 'Perbarui informasi akun Anda')

@section('header-action')
    <a href="{{ route('profile.show') }}" class="btn-secondary"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
@endsection

@section('content')
<div class="pt-2 max-w-lg">
    <div class="card p-8">
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf @method('PUT')

            {{-- Photo --}}
            <div class="text-center">
                <div class="relative inline-block cursor-pointer group" onclick="document.getElementById('photoInput').click()">
                    <img id="photo-preview" src="{{ $user->photo_url }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-2xl object-cover ring-4 ring-green-100">
                    <div class="absolute inset-0 bg-black/40 rounded-2xl opacity-0 group-hover:opacity-100 flex items-center justify-center transition">
                        <i class="fa-solid fa-camera text-white text-xl"></i>
                    </div>
                </div>
                <input type="file" id="photoInput" name="photo" accept="image/*" class="hidden" onchange="previewPhoto(this)">
                <p class="text-xs text-gray-400 mt-2">Klik foto untuk mengubah</p>
            </div>

            <div>
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-input" required>
            </div>
            <div>
                <label class="form-label">Email</label>
                <input type="email" value="{{ $user->email }}" class="form-input bg-gray-50 cursor-not-allowed" disabled>
                <p class="text-xs text-gray-400 mt-1">Email tidak dapat diubah.</p>
            </div>
            <div>
                <label class="form-label">Nomor Telepon</label>
                <div class="relative">
                    <i class="fa-solid fa-phone absolute left-3.5 top-3 text-gray-400 text-sm"></i>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-input pl-10" placeholder="+62 812 3456 7890">
                </div>
            </div>
            <div>
                <label class="form-label">Alamat</label>
                <textarea name="address" rows="3" class="form-input resize-none" placeholder="Alamat lengkap Anda...">{{ old('address', $user->address) }}</textarea>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary flex-1 justify-center py-3">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                </button>
                <a href="{{ route('profile.show') }}" class="btn-secondary">Batal</a>
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
