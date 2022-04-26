<?php

namespace Tests\Unit;

use App\Models\Company;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    public function testCreateCompany(): void
    {
        $company = Company::create([
            'name' => $this->faker->company(),
            'email' => $this->faker->unique->safeEmail(),
            'logo' => $this->faker->imageUrl(),
            'website' => $this->faker->url(),
        ]);

        $this->assertDatabaseHas('companies', $company->toArray());
    }

    public function testShowCompany(): void
    {
        $company = Company::factory()->create();

        $this->assertDatabaseHas('companies', $company->toArray());

        $showCompany = Company::find($company->id);

        $this->assertEquals($company->all(), $showCompany->all());
    }

    public function testUpdateCompany(): void
    {
        $company = Company::factory()->create();

        $this->assertDatabaseHas('companies', $company->toArray());

        $name = 'Testing Name Change';

        $company->update([
            'name' => $name,
        ]);

        $this->assertDatabaseHas('companies', $company->toArray());
    }

    public function testDeleteCompany(): void
    {
        $company = Company::factory()->create();

        $this->assertDatabaseHas('companies', $company->toArray());

        $company->delete();

        $this->assertDatabaseMissing('companies', $company->toArray());
    }
}
