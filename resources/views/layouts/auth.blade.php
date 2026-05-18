<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — SalurkanYuk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="min-h-screen bg-gradient-to-br from-green-50 via-white to-emerald-50 flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-600 rounded-2xl shadow-lg mb-4">
                <i class="fa-solid fa-hand-holding-heart text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-extrabold text-gray-900">SalurkanYuk</h1>
            <p class="text-gray-500 text-sm mt-1">Platform Donasi Barang Berbasis Web</p>
        </div>
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8">
            @if($errors->any())
                <div class="mb-5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                    <ul class="space-y-1">
                        @foreach($errors->all() as $e)
                            <li><i class="fa-solid fa-xmark mr-1"></i>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </div>
        <p class="text-center text-xs text-gray-400 mt-6">© 2025 SalurkanYuk · Berbagi untuk Sesama</p>
    </div>
</body>
</html>
