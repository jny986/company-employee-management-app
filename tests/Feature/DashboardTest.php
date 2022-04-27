<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function testDashboardPage(): void
    {
        $this->actingAs($this->user)
            ->get(route('dashboard'))
            ->assertSuccessful()
            ->assertViewIs('pages.dashboard')
            ->assertSeeText('Dashboard');
    }

    public function testMenuLinks(): void
    {
        $this->actingAs($this->user)
            ->get(route('dashboard'))
            ->assertSuccessful()
            ->assertViewIs('pages.dashboard')
            ->assertSeeTextInOrder([
                'Dashboard',
                'Companies',
                'Employees',
            ])
            ->assertSeeInOrder([
                route('dashboard'),
                route('companies.index'),
                route('employees.index'),
            ]);
    }
}
