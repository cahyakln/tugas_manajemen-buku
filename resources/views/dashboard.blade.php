
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-800">
                    Dashboard Perpustakaan
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Sistem Informasi Manajemen Buku
                </p>
            </div>

            <span class="px-4 py-2 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold">
                {{ Auth::user()->getRoleNames()->first() ?? 'Pengguna' }}
            </span>
        </div>
    </x-slot>

    <div class="min-h-screen bg-slate-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Welcome Banner -->
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-950 via-indigo-800 to-purple-700 p-8 md:p-10 text-white shadow-xl mb-8">
                <div class="relative z-10 max-w-2xl">
                    <p class="text-indigo-200 font-medium mb-2">
                        SISTEM INFORMASI PERPUSTAKAAN
                    </p>

                    <h1 class="text-3xl md:text-4xl font-extrabold mb-3">
                        Halo, {{ Auth::user()->name }}! 👋
                    </h1>

                    <p class="text-indigo-100 text-sm md:text-base leading-relaxed">
                        Selamat datang di Sistem Manajemen Buku.
                        Kelola koleksi buku dan informasi perpustakaan
                        dengan mudah sesuai hak akses akun Anda.
                    </p>

                    @can('view books')
                        <a href="{{ route('books.index') }}"
                           class="inline-flex mt-6 px-6 py-3 bg-white text-indigo-800 font-bold rounded-xl hover:bg-indigo-50 transition shadow-lg">
                            📚 Buka Koleksi Buku →
                        </a>
                    @endcan
                </div>

                <div class="absolute right-8 bottom-0 text-white opacity-10 text-9xl">
                    📚
                </div>
            </div>

            <!-- Menu Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Card Daftar Buku -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl transition">
                    <div class="w-14 h-14 flex items-center justify-center rounded-xl bg-blue-100 text-3xl mb-5">
                        📖
                    </div>

                    <h3 class="text-lg font-bold text-gray-800 mb-2">
                        Koleksi Buku
                    </h3>

                    <p class="text-sm text-gray-500 leading-relaxed mb-5">
                        Lihat seluruh data buku yang tersedia dalam sistem perpustakaan.
                    </p>

                    @can('view books')
                        <a href="{{ route('books.index') }}"
                           class="block text-center py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition">
                            Lihat Koleksi
                        </a>
                    @else
                        <span class="block text-center py-3 bg-gray-200 text-gray-500 rounded-xl">
                            Tidak memiliki akses
                        </span>
                    @endcan
                </div>

                <!-- Card Tambah Buku -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl transition">
                    <div class="w-14 h-14 flex items-center justify-center rounded-xl bg-emerald-100 text-3xl mb-5">
                        ➕
                    </div>

                    <h3 class="text-lg font-bold text-gray-800 mb-2">
                        Tambah Buku
                    </h3>

                    <p class="text-sm text-gray-500 leading-relaxed mb-5">
                        Tambahkan koleksi buku baru beserta informasi penulis dan penerbit.
                    </p>

                    @can('create books')
                        <a href="{{ route('books.create') }}"
                           class="block text-center py-3 bg-emerald-600 text-white rounded-xl font-semibold hover:bg-emerald-700 transition">
                            + Tambah Buku
                        </a>
                    @else
                        <span class="block text-center py-3 bg-gray-200 text-gray-500 rounded-xl">
                            Tidak memiliki akses
                        </span>
                    @endcan
                </div>

                <!-- Card Informasi Akun -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl transition">
                    <div class="w-14 h-14 flex items-center justify-center rounded-xl bg-purple-100 text-3xl mb-5">
                        👤
                    </div>

                    <h3 class="text-lg font-bold text-gray-800 mb-2">
                        Informasi Akun
                    </h3>

                    <p class="text-sm text-gray-500 leading-relaxed mb-5">
                        Informasi pengguna yang sedang masuk ke sistem.
                    </p>

                    <div class="bg-purple-50 rounded-xl p-3">
                        <p class="text-xs text-purple-500">Nama Pengguna</p>
                        <p class="font-bold text-purple-900">
                            {{ Auth::user()->name }}
                        </p>

                        <p class="text-xs text-purple-500 mt-2">Email</p>
                        <p class="font-semibold text-purple-900 break-all">
                            {{ Auth::user()->email }}
                        </p>
                    </div>
                </div>

            </div>

            <!-- Information -->
            <div class="mt-8 rounded-2xl bg-white border border-gray-100 p-6 shadow-sm">
                <h3 class="text-lg font-bold text-gray-800 mb-2">
                    ℹ️ Informasi Sistem
                </h3>

                <p class="text-sm text-gray-500 leading-relaxed">
                    Sistem Manajemen Buku menggunakan Laravel Breeze
                    untuk autentikasi dan Spatie Laravel Permission
                    untuk mengatur hak akses Admin, Dosen, dan Mahasiswa.
                </p>
            </div>

            <div class="text-center text-sm text-gray-400 mt-8">
                © {{ date('Y') }} Sistem Manajemen Buku
            </div>

        </div>
    </div>
</x-app-layout>
