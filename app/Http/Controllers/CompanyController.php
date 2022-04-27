<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexCompanyRequest;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use App\Models\Employee;
use App\Models\User;
use App\Notifications\CompanyAdded;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CompanyController extends Controller
{
    public function index(IndexCompanyRequest $request): View
    {
        $companies = Company::paginate(10)->withQueryString();

        return view('pages.companies.index', ['companies' => $companies]);
    }

    public function create(): View
    {
        $company = Company::make();

        return view('pages.companies.create', ['company' => $company]);
    }

    public function store(StoreCompanyRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->has('logo') && !empty($request->logo)) {
            $data['logo'] = $request->logo->store('logos', 'public');
        }

        $company = Company::create($data);

        $user = User::where('email', 'admin@admin.com')->first();

        $user->notify(new CompanyAdded($company));

        return redirect(route('companies.show', $company->id));
    }

    public function show(Company $company): View
    {
        $employees = Employee::where('company_id', $company->id)
            ->paginate(10)
            ->withQueryString();

        return view('pages.companies.show', [
            'company' => $company,
            'employees' => $employees,
        ]);
    }

    public function edit(Company $company): View
    {
        return view('pages.companies.edit', ['company' => $company]);
    }

    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $data = $request->validated();

        unset($data['logo']);

        if ($request->has('logo') && !empty($request->logo)) {
            $data['logo'] = $request->logo->store('logos', 'public');
        }

        $company->update($data);

        return redirect(route('companies.show', $company->id));
    }

    public function destroy(Company $company): RedirectResponse
    {
        $company->delete();

        return redirect(route('companies.index'));
    }
}
