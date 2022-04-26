<?php

namespace Tests\Unit;

use App\Models\Company;
use App\Models\Employee;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class EmployeeTest extends TestCase
{
    public function testCreateEmployee(): void
    {
        $employee = Employee::create([
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
        ]);

        $this->assertDatabaseHas('employees', $employee->toArray());
    }

    public function testShowEmployee(): void
    {
        $employee = Employee::factory()->create();

        $this->assertDatabaseHas('employees', $employee->toArray());

        $showEmployee = Employee::find($employee->id);

        $this->assertEquals($employee->toArray(), $showEmployee->toArray());
    }

    public function testUpdateEmployee(): void
    {
        $employee = Employee::factory()->create();

        $this->assertDatabaseHas('employees', $employee->toArray());

        $employee->update([
            'first_name' => 'Testing Update First',
            'last_name' => 'Testing Update Last',
        ]);

        $this->assertDatabaseHas('employees', $employee->toArray());
    }

    public function testDeleteEmployee(): void
    {
        $employee = Employee::factory()->create();

        $this->assertDatabaseHas('employees', $employee->toArray());

        $employee->delete();

        $this->assertDatabaseMissing('employees', $employee->toArray());
    }

    public function testEmployeeBelongsToCompany(): void
    {
        $employee = Employee::factory()->create();

        $this->assertDatabaseHas('employees', $employee->toArray());

        $company = Company::find($employee->company_id);

        $this->assertDatabaseHas('companies', $company->toArray());

        $this->assertDatabaseHas('companies', $employee->company->toArray());
    }
}
