
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Buku
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <form action="{{ route('books.store') }}" method="POST">
                    @csrf

                    <div class="space-y-4">
                        <div>
                            <label class="block font-medium text-sm text-gray-700">
                                Judul Buku *
                            </label>
                            <input type="text" name="title" value="{{ old('title') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300"
                                   required>
                            @error('title')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">
                                Penulis *
                            </label>
                            <input type="text" name="author" value="{{ old('author') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300"
                                   required>
                            @error('author')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">
                                Penerbit
                            </label>
                            <input type="text" name="publisher" value="{{ old('publisher') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300">
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">
                                Tahun Terbit
                            </label>
                            <input type="number" name="year" value="{{ old('year') }}"
                                   min="1000" max="9999"
                                   class="mt-1 block w-full rounded-md border-gray-300">
                            @error('year')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">
                                ISBN
                            </label>
                            <input type="text" name="isbn" value="{{ old('isbn') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300">
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">
                                Deskripsi
                            </label>
                            <textarea name="description" rows="4"
                                      class="mt-1 block w-full rounded-md border-gray-300">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="flex gap-3 mt-6">
                        <button type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                            Simpan Buku
                        </button>

                        <a href="{{ route('books.index') }}"
                           class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                            Batal
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
