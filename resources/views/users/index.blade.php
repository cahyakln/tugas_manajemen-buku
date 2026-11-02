
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Manajemen Pengguna
            </h2>

            <a href="{{ route('dashboard') }}"
               class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="rounded-lg bg-green-100 p-4 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="rounded-lg bg-red-100 p-4 text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-lg bg-red-100 p-4 text-red-800">
                    <ul class="list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="overflow-hidden rounded-xl bg-white shadow-sm">
                <div class="border-b border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Daftar Pengguna
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Kelola akun dan hak akses pengguna aplikasi.
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-600">
                                    No.
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-600">
                                    Nama
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-600">
                                    Email
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-600">
                                    Role
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-600">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse ($users as $user)
                                <tr>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                                        {{ $users->firstItem() + $loop->index }}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-800">
                                        {{ $user->name }}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                                        {{ $user->email }}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                                        @forelse ($user->roles as $role)
                                            <span class="rounded-full bg-indigo-100 px-3 py-1 text-xs font-medium text-indigo-700">
                                                {{ $role->name }}
                                            </span>
                                        @empty
                                            <span class="text-gray-400">
                                                Belum memiliki role
                                            </span>
                                        @endforelse
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4">
                                        @if ($user->id !== auth()->id())
                                            <form action="{{ route('users.updateRole', $user) }}"
                                                  method="POST"
                                                  class="flex items-center gap-2">
                                                @csrf
                                                @method('PATCH')

                                                <select name="role"
                                                        required
                                                        class="rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->name }}"
                                                            @selected($user->hasRole($role->name))>
                                                            {{ $role->name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <button type="submit"
                                                        class="rounded-lg bg-indigo-600 px-3 py-2 text-xs font-semibold text-white hover:bg-indigo-700">
                                                    Simpan
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-gray-400">
                                                Akun sendiri
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5"
                                        class="px-6 py-8 text-center text-sm text-gray-500">
                                        Belum ada pengguna.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-gray-200 p-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
