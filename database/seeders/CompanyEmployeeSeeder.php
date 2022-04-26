<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanyEmployeeSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        Company::factory()
            ->count(10)
            ->hasEmployees(10)
            ->create();
    }
}
