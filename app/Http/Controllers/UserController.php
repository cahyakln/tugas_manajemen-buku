<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()->can('manage users'), 403);

        $users = User::with('roles')
            ->orderBy('name')
            ->paginate(10);

        $roles = Role::where('guard_name', 'web')
            ->orderBy('name')
            ->get();

        return view('users.index', compact('users', 'roles'));
    }

    public function updateRole(Request $request, User $user)
    {
        abort_unless(auth()->user()->can('manage users'), 403);

        // Admin tidak boleh mengubah role akunnya sendiri.
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Kamu tidak dapat mengubah role akun sendiri.');
        }

        $validated = $request->validate([
            'role' => [
                'required',
                'string',
                Rule::exists('roles', 'name')
                    ->where('guard_name', 'web'),
            ],
        ]);

        $user->syncRoles([$validated['role']]);

        return redirect()
            ->route('users.index')
            ->with('success', 'Role pengguna berhasil diperbarui.');
    }
}
