<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\User;
use App\Models\Role;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Create a user for testing
     */
    protected function createUser(array $attributes = []): User
    {
        $role = Role::factory()->create(['name' => 'user']);
        return User::factory()->create(array_merge(['role_id' => $role->id], $attributes));
    }

    /**
     * Create and authenticate a user
     */
    protected function actingAsUser(array $attributes = []): User
    {
        $user = $this->createUser($attributes);
        $this->actingAs($user);
        return $user;
    }

    /**
     * Create an admin user
     */
    protected function createAdmin(array $attributes = []): User
    {
        $role = Role::factory()->create(['name' => 'admin']);
        return User::factory()->create(array_merge(['role_id' => $role->id], $attributes));
    }
}