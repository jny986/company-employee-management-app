<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    public function setup(): void
    {
        parent::setup();

        $this->user = User::factory()->create();
    }

    public function testCompanyPage(): void
    {
        $companies = Company::factory()
            ->count(20)
            ->create();

        $company = $companies->first();

        $this->actingAs($this->user)
            ->get(route('companies.index'))
            ->assertSuccessful()
            ->assertViewIs('pages.companies.index')
            ->assertSee($company->name);

        $company = $companies->last();

        $this->actingAs($this->user)
            ->get(route('companies.index', ['page' => 2]))
            ->assertSuccessful()
            ->assertViewIs('pages.companies.index')
            ->assertSeeText($company->name);
    }

    public function testCreateCompanyPage(): void
    {
        $this->actingAs($this->user)->get(route('companies.create'))
            ->assertSuccessful()
            ->assertViewIs('pages.companies.create')
            ->assertSeeText('Create Company');
    }

    public function testShowCompanyPage(): void
    {
        $company = Company::factory()
            ->hasEmployees(10)
            ->create();

        $this->actingAs($this->user)
            ->get(route('companies.show', $company->id))
            ->assertSuccessful()
            ->assertViewIs('pages.companies.show')
            ->assertSeeText($company->name)
            ->assertSeeText('Edit');
    }

    public function testEditPage()


}
