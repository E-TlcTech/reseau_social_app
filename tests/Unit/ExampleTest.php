<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_that_true_is_true()
    {
        $this->assertTrue(true);
    }

    public function test_user_can_be_created()
    {
        // Create a role first
        $role = Role::factory()->create(['name' => 'user']);

        // Create a user
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'role_id' => $role->id
        ]);

        // Assert the user exists in the database
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com'
        ]);

        // Assert the user has the correct role
        $this->assertEquals('user', $user->role->name);
    }

    public function test_user_has_required_attributes()
    {
        $role = Role::factory()->create();
        $user = User::factory()->create(['role_id' => $role->id]);

        // Test that user has expected attributes
        $this->assertNotNull($user->pseudo);
        $this->assertNotNull($user->email);
        $this->assertNotNull($user->password);
        $this->assertNotNull($user->role_id);
    }

    public function test_user_email_must_be_unique()
    {
        $role = Role::factory()->create();
        
        // Create first user
        User::factory()->create([
            'email' => 'test@example.com',
            'role_id' => $role->id
        ]);

        // Attempt to create second user with same email should fail
        $this->expectException(\Illuminate\Database\QueryException::class);
        
        User::factory()->create([
            'email' => 'test@example.com',
            'role_id' => $role->id
        ]);
    }

    public function test_role_can_be_created()
    {
        $role = Role::factory()->create(['name' => 'admin']);

        $this->assertDatabaseHas('roles', [
            'name' => 'admin'
        ]);

        $this->assertEquals('admin', $role->name);
    }

    public function test_user_belongs_to_role()
    {
        $role = Role::factory()->create(['name' => 'moderator']);
        $user = User::factory()->create(['role_id' => $role->id]);

        // Test the relationship
        $this->assertInstanceOf(Role::class, $user->role);
        $this->assertEquals('moderator', $user->role->name);
    }

    public function test_role_has_many_users()
    {
        $role = Role::factory()->create(['name' => 'user']);
        
        // Create multiple users with the same role
        User::factory()->count(3)->create(['role_id' => $role->id]);

        // Test the relationship
        $this->assertCount(3, $role->users);
        $this->assertInstanceOf(User::class, $role->users->first());
    }
}