<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CompanyController extends Controller
{
    public function index()
    {
        $defaultPerPage = 10;
        $perPage = request()->query('per_page', $defaultPerPage);

        $companies = QueryBuilder::for(Company::class)
            ->allowedFilters([
                AllowedFilter::partial('company_code')
            ])
            ->paginate($perPage);

        return CompanyResource::collection($companies);
    }

    public function store (Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|unique:companies|max:255',
            'company_code' => 'required|unique:companies|max:2|min:2',
            'company_address' => 'required|max:255',
        ]);

        $company = Company::create($validated);

        return CompanyResource::make($company);
    }

    public function update (Request $request, Company $company)
    {
        $validated = $request->validate([
            'company_name' => [
                'required',
                'max:255',
                Rule::unique('companies')->ignore($company),
            ],
            'company_code' => 'required|unique:companies|max:2|min:2',
            'company_address' => 'required|max:255',
        ]);

        $company->update($validated);

        return CompanyResource::make($company);
    }

    public function destroy (Company $company)
    {
        $company->delete();

        return response()->json(null, 204);
    }

    public function show (Company $company) {
        return CompanyResource::make($company);
    }
}
