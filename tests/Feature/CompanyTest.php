<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use App\Notifications\CompanyAdded;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email' => 'admin@admin.com',
        ]);
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
        $this->actingAs($this->user)
            ->get(route('companies.create'))
            ->assertSuccessful()
            ->assertViewIs('pages.companies.create')
            ->assertSeeText('Create Company')
            ->assertSeeTextInOrder([
                'Name:',
                'Email:',
                'Website:',
                'Logo:',
            ])
            ->assertSeeText('Save');
    }

    public function testStoreCompany(): void
    {
        Storage::fake('public');
        Notification::fake();

        $company = Company::factory()
            ->make([
                'logo' => UploadedFile::fake()->image('logo.jpg', 200, 200)
            ]);

        $companyData = $company->only([
            'name',
            'email',
            'website',
            'logo',
        ]);

        $data = array_merge($companyData, ['_token' => csrf_token()]);

        $this->actingAs($this->user)
            ->post(route('companies.store'), $data)
            ->assertRedirect();

        Notification::assertSentTo([$this->user], CompanyAdded::class);

        unset($data['logo']);
        unset($data['_token']);

        $this->assertDatabaseHas('companies', $data);

        $company = Company::where($data)
            ->firstOrFail();

        Storage::disk('public')->assertExists($company->logo);
    }

    public function testStoreCompanyImageValidation(): void
    {
        Storage::fake('public');

        $company = Company::factory()
            ->make([
                'logo' => UploadedFile::fake()->image('logo.jpg', 50, 50)
            ]);

        $companyData = $company->only([
            'name',
            'email',
            'website',
            'logo',
        ]);

        $data = array_merge($companyData, ['_token' => csrf_token()]);

        $this->actingAs($this->user)
            ->post(route('companies.store'), $data)
            ->assertInvalid('logo');

        Storage::disk('public')->assertDirectoryEmpty('logos');
    }

    public function testStoreCompanyNameValidation(): void
    {
        Storage::fake('public');

        $company = Company::factory()
            ->make([
                'name' => null,
                'logo' => null,
            ]);

        $companyData = $company->only([
            'name',
            'email',
            'website',
            'logo',
        ]);

        $data = array_merge($companyData, ['_token' => csrf_token()]);

        $this->actingAs($this->user)
            ->post(route('companies.store'), $data)
            ->assertInvalid('name');

        Storage::disk('public')->assertDirectoryEmpty('logos');
    }

    public function testShowCompanyPage(): void
    {
        $company = Company::factory()
            ->hasEmployees(20)
            ->create();

        $employee = $company->employees->first();

        $this->actingAs($this->user)
            ->get(route('companies.show', $company->id))
            ->assertSuccessful()
            ->assertViewIs('pages.companies.show')
            ->assertSeeText($company->name)
            ->assertSeeText('Edit')
            ->assertSeeText($employee->email);

        $employee = $company->employees->last();

        $this->actingAs($this->user)
            ->get(route('companies.show', [
                'company' => $company->id,
                'page' => 2,
            ]))
            ->assertSuccessful()
            ->assertViewIs('pages.companies.show')
            ->assertSeeText($company->name)
            ->assertSeeText($employee->email);
    }

    public function testEditCompanyPage(): void
    {
        $company = Company::factory()
            ->create();


        $this->actingAs($this->user)
            ->get(route('companies.edit', $company->id))
            ->assertSuccessful()
            ->assertViewIs('pages.companies.edit')
            ->assertSeeText($company->name)
            ->assertSeeTextInOrder([
                'Name:',
                'Email:',
                'Website:',
                'Logo:',
            ])
            ->assertSeeText('Save');
    }

    public function testUpdateCompany(): void
    {
        Storage::fake('public');

        $company = Company::factory()
            ->create();

        $companyData = $company->only([
            'id',
            'name',
            'email',
            'website',
        ]);

        $companyData['logo'] = UploadedFile::fake()->image('logo.jpg', 200, 200);

        $data = array_merge($companyData, ['_token' => csrf_token()]);

        $this->actingAs($this->user)
            ->patch(route('companies.update', $company->id), $data)
            ->assertRedirect();

        unset($data['logo']);
        unset($data['_token']);

        $this->assertDatabaseHas('companies', $data);

        $company->refresh();

        Storage::disk('public')->assertExists($company->logo);
    }
    public function testUpdateCompanyImageValidation(): void
    {
        Storage::fake('public');

        $company = Company::factory()
            ->create();

        $companyData = $company->only([
            'id',
            'name',
            'email',
            'website',
        ]);

        $companyData['logo'] = UploadedFile::fake()->image('logo.jpg', 50, 50);

        $data = array_merge($companyData, ['_token' => csrf_token()]);

        $this->actingAs($this->user)
            ->post(route('companies.store'), $data)
            ->assertInvalid('logo');

        Storage::disk('public')->assertDirectoryEmpty('logos');
    }

    public function testUpdateCompanyNameValidation(): void
    {
        Storage::fake('public');

        $company = Company::factory()
            ->create();

        $companyData = $company->only([
            'id',
            'name',
            'email',
            'website',
        ]);

        $companyData['logo'] = null;
        $companyData['name'] = null;

        $data = array_merge($companyData, ['_token' => csrf_token()]);

        $this->actingAs($this->user)
            ->post(route('companies.store'), $data)
            ->assertInvalid('name');

        Storage::disk('public')->assertDirectoryEmpty('logos');
    }

    public function testDeleteCompany(): void
    {
        $deleteCompany = Company::factory()->create();

        $keepCompany = Company::factory()->create();

        $this->actingAs($this->user)
            ->delete(route('companies.destroy', $deleteCompany->id))
            ->assertRedirect(route('companies.index'));

        $this->assertDatabaseMissing('companies', $deleteCompany->toArray());

        $this->assertDatabaseHas('companies', $keepCompany->toArray());
    }
}
