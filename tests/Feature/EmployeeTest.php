<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function testEmployeePage(): void
    {
        $employees = Employee::factory()
            ->count(20)
            ->create();

        $employee = $employees->first();

        $this->actingAs($this->user)
            ->get(route('employees.index'))
            ->assertSuccessful()
            ->assertViewIs('pages.employees.index')
            ->assertSee($employee->first_name)
            ->assertSee($employee->last_name);

        $employee = $employees->last();

        $this->actingAs($this->user)
            ->get(route('employees.index', ['page' => 2]))
            ->assertSuccessful()
            ->assertViewIs('pages.employees.index')
            ->assertSee($employee->first_name)
            ->assertSee($employee->last_name);
    }

    public function testCreateEmployeePage(): void
    {
        $this->actingAs($this->user)
            ->get(route('employees.create'))
            ->assertSuccessful()
            ->assertViewIs('pages.employees.create')
            ->assertSeeText('Create Employee')
            ->assertSeeTextInOrder([
                'First Name:',
                'Last Name:',
                'Company:',
                'Email:',
                'Phone:',
            ])
            ->assertSeeText('Save');
    }

    public function testStoreEmployee(): void
    {
        $employee = Employee::factory()
            ->make();

        $employeeData = $employee->only([
            'first_name',
            'last_name',
            'company_id',
            'email',
            'phone',
        ]);

        $data = array_merge($employeeData, ['_token' => csrf_token()]);

        $this->actingAs($this->user)
            ->post(route('employees.store'), $data)
            ->assertRedirect();

        unset($data['_token']);

        $this->assertDatabaseHas('employees', $data);
    }

    public function testStoreEmployeeFirstNameValidation(): void
    {
        $employee = Employee::factory()->make([
            'first_name' => null,
        ]);

        $employeeData = $employeeData = $employee->only([
            'first_name',
            'last_name',
            'company_id',
            'email',
            'phone',
        ]);

        $data = array_merge($employeeData, ['_token' => csrf_token()]);

        $this->actingAs($this->user)
            ->post(route('employees.store'), $data)
            ->assertInvalid('first_name');
    }

    public function testStoreEmployeeLastNameValidation(): void
    {
        $employee = Employee::factory()->make([
            'last_name' => null,
        ]);

        $employeeData = $employeeData = $employee->only([
            'first_name',
            'last_name',
            'company_id',
            'email',
            'phone',
        ]);

        $data = array_merge($employeeData, ['_token' => csrf_token()]);

        $this->actingAs($this->user)
            ->post(route('employees.store'), $data)
            ->assertInvalid('last_name');
    }

    public function testShowEmployeePage(): void
    {
        $employee = Employee::factory()->create();

        $employee->load('company');

        $this->actingAs($this->user)
            ->get(route('employees.show', $employee->id))
            ->assertSuccessful()
            ->assertViewIs('pages.employees.show')
            ->assertSeeText("Employee - $employee->first_name $employee->last_name")
            ->assertSeeTextInOrder([
                'First Name:',
                $employee->first_name
            ])
            ->assertSeeTextInOrder([
                'Last Name:',
                $employee->last_name
            ])
            ->assertSeeText('Edit');
    }

    public function testEditEmployeePage(): void
    {
        $employee = Employee::factory()->create();


        $this->actingAs($this->user)
            ->get(route('employees.edit', $employee->id))
            ->assertSuccessful()
            ->assertViewIs('pages.employees.edit')
            ->assertSeeText($employee->first_name)
            ->assertSeeTextInOrder([
                'First Name:',
                'Last Name',
                'Company:',
                'Email:',
                'Phone:',
            ])
            ->assertSeeText('Save');
    }

    public function testUpdateEmployee(): void
    {
        $employee = Employee::factory()->create();

        $employeeData = $employee->only([
            'first_name',
            'last_name',
            'company_id',
            'email',
            'phone',
        ]);

        $data = array_merge($employeeData, ['_token' => csrf_token()]);

        $this->actingAs($this->user)
            ->patch(route('employees.update', $employee->id), $data)
            ->assertRedirect();

        unset($data['_token']);

        $this->assertDatabaseHas('employees', $data);
    }

    public function testUpdateEmployeeFirstNameValidation(): void
    {
        $employee = Employee::factory()->create();

        $employeeData = $employeeData = $employee->only([
            'first_name',
            'last_name',
            'company_id',
            'email',
            'phone',
        ]);

        $employeeData['first_name'] = null;

        $data = array_merge($employeeData, ['_token' => csrf_token()]);

        $this->actingAs($this->user)
            ->patch(route('employees.update', $employee->id), $data)
            ->assertInvalid('first_name');
    }

    public function testUpdateEmployeeLastNameValidation(): void
    {
        $employee = Employee::factory()->create();

        $employeeData = $employeeData = $employee->only([
            'first_name',
            'last_name',
            'company_id',
            'email',
            'phone',
        ]);

        $employeeData['last_name'] = null;

        $data = array_merge($employeeData, ['_token' => csrf_token()]);

        $this->actingAs($this->user)
            ->patch(route('employees.update', $employee->id), $data)
            ->assertInvalid('last_name');
    }

    public function testDeleteEmployee(): void
    {
        $deleteEmployee = Employee::factory()->create();

        $keepEmployee = Employee::factory()->create();

        $this->actingAs($this->user)
            ->delete(route('employees.destroy', $deleteEmployee->id))
            ->assertRedirect(route('employees.index'));

        $this->assertDatabaseMissing('employees', $deleteEmployee->toArray());

        $this->assertDatabaseHas('employees', $keepEmployee->toArray());
    }
}
