<?php
namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class UserAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::firstOrCreate([
            'name' => 'manage users',
            'guard_name' => 'web',
        ]);

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

        $admin->syncPermissions(['manage users']);
        $dosen->syncPermissions([]);
        $mahasiswa->syncPermissions([]);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }

    private function createUserWithRole(string $role): User
    {
        $user = User::factory()->create();
        $user->assignRole($role);

        return $user;
    }

    public function test_guest_cannot_access_user_management(): void
    {
        $this->get(route('users.index'))
            ->assertRedirect(route('login'));
    }

    public function test_admin_can_view_user_management(): void
    {
        $admin = $this->createUserWithRole('Admin');

        $this->actingAs($admin)
            ->get(route('users.index'))
            ->assertOk();
    }

    public function test_admin_can_change_user_role(): void
    {
        $admin = $this->createUserWithRole('Admin');
        $dosen = $this->createUserWithRole('Dosen');

        $this->actingAs($admin)
            ->patch(route('users.updateRole', $dosen), [
                'role' => 'Mahasiswa',
            ])
            ->assertRedirect(route('users.index'));

        $this->assertTrue($dosen->fresh()->hasRole('Mahasiswa'));
        $this->assertFalse($dosen->fresh()->hasRole('Dosen'));
    }

    public function test_admin_cannot_change_own_role(): void
    {
        $admin = $this->createUserWithRole('Admin');

        $this->actingAs($admin)
            ->patch(route('users.updateRole', $admin), [
                'role' => 'Mahasiswa',
            ])
            ->assertRedirect()
            ->assertSessionHas('error');

        $this->assertTrue($admin->fresh()->hasRole('Admin'));
    }

    public function test_dosen_cannot_access_user_management(): void
    {
        $dosen = $this->createUserWithRole('Dosen');

        $this->actingAs($dosen)
            ->get(route('users.index'))
            ->assertForbidden();
    }

    public function test_mahasiswa_cannot_access_user_management(): void
    {
        $mahasiswa = $this->createUserWithRole('Mahasiswa');

        $this->actingAs($mahasiswa)
            ->get(route('users.index'))
            ->assertForbidden();
    }

    public function test_non_admin_cannot_change_user_role(): void
    {
        $dosen = $this->createUserWithRole('Dosen');
        $mahasiswa = $this->createUserWithRole('Mahasiswa');

        $this->actingAs($dosen)
            ->patch(route('users.updateRole', $mahasiswa), [
                'role' => 'Admin',
            ])
            ->assertForbidden();

        $this->assertTrue($mahasiswa->fresh()->hasRole('Mahasiswa'));
    }
}
