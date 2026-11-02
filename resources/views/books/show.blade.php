
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Buku
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <h3 class="text-2xl font-bold text-gray-800 mb-6">
                    {{ $book->title }}
                </h3>

                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Penulis</p>
                        <p class="font-medium">{{ $book->author }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Penerbit</p>
                        <p class="font-medium">{{ $book->publisher ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Tahun Terbit</p>
                        <p class="font-medium">{{ $book->year ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">ISBN</p>
                        <p class="font-medium">{{ $book->isbn ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Deskripsi</p>
                        <p class="font-medium whitespace-pre-line">
                            {{ $book->description ?? '-' }}
                        </p>
                    </div>
                </div>

                <div class="flex gap-3 mt-8">
                    <a href="{{ route('books.index') }}"
                       class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                        Kembali
                    </a>

                    @can('edit books')
                        <a href="{{ route('books.edit', $book) }}"
                           class="px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600">
                            Edit Buku
                        </a>
                    @endcan
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
