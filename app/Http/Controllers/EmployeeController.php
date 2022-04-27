<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function index(): View
    {
        $employees = Employee::with('company')
            ->paginate(10)
            ->withQueryString();

        return view('pages.employees.index', ['employees' => $employees]);
    }

    public function create(): View
    {
        $employee = Employee::make();

        $companies = Company::select(['id', 'name'])->get();

        return view('pages.employees.create', [
            'employee' => $employee,
            'companies' => $companies,
        ]);
    }

    public function store(StoreEmployeeRequest $request): RedirectResponse
    {
        $employee = Employee::create($request->validated());

        return redirect(route('employees.show', $employee->id));
    }

    public function show(Employee $employee): View
    {
        $employee->load(['company']);

        return view('pages.employees.show', ['employee' => $employee]);
    }

    public function edit(Employee $employee): View
    {
        $companies = Company::select(['id', 'name'])->get();

        return view('pages.employees.edit', [
            'employee' => $employee,
            'companies' => $companies,
        ]);
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee): RedirectResponse
    {
        $employee->update($request->validated());

        return redirect(route('employees.show', $employee->id));
    }

    public function destroy(Employee $employee): RedirectResponse
    {
        $employee->delete();

        return redirect(route('employees.index'));
    }
}
