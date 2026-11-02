
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Manajemen Buku
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Kelola koleksi buku perpustakaan.
                </p>
            </div>

            <a href="{{ route('books.create') }}"
               class="inline-flex items-center justify-center px-5 py-2.5 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition">
                + Tambah Buku
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-5 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">

                <div class="p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">
                                Daftar Koleksi Buku
                            </h3>
                            <p class="text-sm text-gray-500">
                                Data seluruh buku yang tersimpan dalam sistem.
                            </p>
                        </div>

                        <span class="px-3 py-2 bg-indigo-50 text-indigo-700 rounded-lg text-sm font-medium">
                            Total: {{ $books->total() }} Buku
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                                <tr>
                                    <th class="px-4 py-4">No.</th>
                                    <th class="px-4 py-4">Judul Buku</th>
                                    <th class="px-4 py-4">Penulis</th>
                                    <th class="px-4 py-4">Penerbit</th>
                                    <th class="px-4 py-4">Tahun</th>
                                    <th class="px-4 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($books as $book)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-4 py-4">
                                            {{ $loop->iteration + ($books->currentPage() - 1) * $books->perPage() }}
                                        </td>

                                        <td class="px-4 py-4 font-semibold text-gray-800">
                                            {{ $book->title }}
                                        </td>

                                        <td class="px-4 py-4">
                                            {{ $book->author }}
                                        </td>

                                        <td class="px-4 py-4">
                                            {{ $book->publisher ?? '-' }}
                                        </td>

                                        <td class="px-4 py-4">
                                            {{ $book->year ?? '-' }}
                                        </td>

                                        <td class="px-4 py-4">
                                            <div class="flex items-center justify-center gap-3">

                                                <a href="{{ route('books.show', $book) }}"
                                                   class="text-blue-600 hover:text-blue-800 font-medium">
                                                    Detail
                                                </a>

                                                @can('edit books')
                                                    <a href="{{ route('books.edit', $book) }}"
                                                       class="text-amber-600 hover:text-amber-800 font-medium">
                                                        Edit
                                                    </a>
                                                @endcan

                                                @can('delete books')
                                                    <form action="{{ route('books.destroy', $book) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit"
                                                                class="text-red-600 hover:text-red-800 font-medium">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                @endcan

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-10 text-center">
                                            <div class="text-gray-400 text-4xl mb-3">
                                                📚
                                            </div>
                                            <p class="font-semibold text-gray-700">
                                                Belum Ada Data Buku
                                            </p>
                                            <p class="text-gray-500 mt-1">
                                                Silakan tambahkan buku pertama ke dalam sistem.
                                            </p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $books->links() }}
                    </div>

                </div>
            </div>

            <div class="mt-5 text-sm text-gray-500">
                Sistem Manajemen Buku — Laravel Breeze & Spatie Permission.
            </div>

        </div>
    </div>
</x-app-layout>
