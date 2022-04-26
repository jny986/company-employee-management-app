<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function testGuestRedirect(): void
    {
        $this->get(route('dashboard'))
            ->assertRedirect(route('login'));
    }

    public function testlogout(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('logout'))
            ->assertRedirect(route('dashboard'));
    }
}
