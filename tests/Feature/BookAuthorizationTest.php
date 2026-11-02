<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class BookAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'view books',
            'create books',
            'edit books',
            'delete books',
            'manage users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $admin = Role::firstOrCreate([
            'name' => 'Admin',
            'guard_name' => 'web',
        ]);

        $dosen = Role::firstOrCreate([
            'name' => 'Dosen',
            'guard_name' => 'web',
        ]);

        $mahasiswa = Role::firstOrCreate([
            'name' => 'Mahasiswa',
            'guard_name' => 'web',
        ]);

        $admin->syncPermissions($permissions);

        $dosen->syncPermissions([
            'view books',
            'create books',
            'edit books',
        ]);

        $mahasiswa->syncPermissions([
            'view books',
        ]);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }

    private function createUserWithRole(string $role): User
    {
        $user = User::factory()->create();
        $user->assignRole($role);

        return $user;
    }

    private function createBook(): Book
    {
        return Book::create([
            'title' => 'Buku Pengujian',
            'author' => 'Penulis Pengujian',
            'publisher' => 'Penerbit Pengujian',
            'year' => 2025,
            'isbn' => '9786020001234',
            'description' => 'Buku untuk pengujian hak akses.',
        ]);
    }

    public function test_guest_is_redirected_to_login_when_viewing_books(): void
    {
        $this->get(route('books.index'))
            ->assertRedirect(route('login'));
    }

    public function test_admin_can_create_edit_and_delete_books(): void
    {
        $admin = $this->createUserWithRole('Admin');

        $this->actingAs($admin)
            ->post(route('books.store'), [
                'title' => 'Buku Admin',
                'author' => 'Penulis Admin',
                'publisher' => 'Penerbit Admin',
                'year' => 2025,
                'isbn' => '9786020001111',
                'description' => 'Buku milik Admin.',
            ])
            ->assertRedirect(route('books.index'));

        $book = Book::where('title', 'Buku Admin')->firstOrFail();

        $this->actingAs($admin)
            ->put(route('books.update', $book), [
                'title' => 'Buku Admin Diperbarui',
                'author' => 'Penulis Admin',
                'publisher' => 'Penerbit Admin',
                'year' => 2026,
                'isbn' => '9786020001111',
                'description' => 'Buku sudah diperbarui.',
            ])
            ->assertRedirect(route('books.index'));

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => 'Buku Admin Diperbarui',
        ]);

        $this->actingAs($admin)
            ->delete(route('books.destroy', $book))
            ->assertRedirect(route('books.index'));

        $this->assertDatabaseMissing('books', [
            'id' => $book->id,
        ]);
    }

    public function test_dosen_can_view_create_and_edit_books(): void
    {
        $dosen = $this->createUserWithRole('Dosen');
        $book = $this->createBook();

        $this->actingAs($dosen)
            ->get(route('books.index'))
            ->assertOk();

        $this->actingAs($dosen)
            ->post(route('books.store'), [
                'title' => 'Buku Dosen',
                'author' => 'Penulis Dosen',
                'publisher' => 'Penerbit Dosen',
                'year' => 2025,
                'isbn' => '9786020002222',
                'description' => 'Buku milik Dosen.',
            ])
            ->assertRedirect(route('books.index'));

        $this->actingAs($dosen)
            ->put(route('books.update', $book), [
                'title' => 'Buku Dosen Diperbarui',
                'author' => 'Penulis Dosen',
                'publisher' => 'Penerbit Dosen',
                'year' => 2026,
                'isbn' => '9786020003333',
                'description' => 'Buku diperbarui oleh Dosen.',
            ])
            ->assertRedirect(route('books.index'));

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => 'Buku Dosen Diperbarui',
        ]);
    }

    public function test_dosen_cannot_delete_books(): void
    {
        $dosen = $this->createUserWithRole('Dosen');
        $book = $this->createBook();

        $this->actingAs($dosen)
            ->delete(route('books.destroy', $book))
            ->assertForbidden();

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
        ]);
    }

    public function test_mahasiswa_can_view_but_cannot_create_edit_or_delete_books(): void
    {
        $mahasiswa = $this->createUserWithRole('Mahasiswa');
        $book = $this->createBook();

        $this->actingAs($mahasiswa)
            ->get(route('books.index'))
            ->assertOk();

        $this->actingAs($mahasiswa)
            ->get(route('books.create'))
            ->assertForbidden();

        $this->actingAs($mahasiswa)
            ->get(route('books.edit', $book))
            ->assertForbidden();

        $this->actingAs($mahasiswa)
            ->post(route('books.store'), [
                'title' => 'Buku Mahasiswa',
                'author' => 'Penulis Mahasiswa',
            ])
            ->assertForbidden();

        $this->actingAs($mahasiswa)
            ->put(route('books.update', $book), [
                'title' => 'Buku Diubah Mahasiswa',
                'author' => 'Penulis Mahasiswa',
            ])
            ->assertForbidden();

        $this->actingAs($mahasiswa)
            ->delete(route('books.destroy', $book))
            ->assertForbidden();

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => 'Buku Pengujian',
        ]);
    }
}
