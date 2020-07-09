<?php


namespace Modules\Products\Repositories;


use Illuminate\Support\Str;
use Modules\Products\Entities\Model\Company;
use PHPUnit\Util\Exception;

class CompanyRepository
{
    public function allCompany()
    {
        return Company::all();
    }

    public function createCompany($request)
    {
        $user = Company::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->status
        ]);

        if (! $user) {
            throw new Exception('New user registration failed');
        }

        return $user;
    }

    public function updateCompany($request, $id)
    {
        $company = Company::find($id);

        if (!$company) {
            throw new Exception('Company not found');
        }

        if (isset($request->name)) {
            $company->name = $request->name;
            $company->slug = Str::slug($request->name);
        }

        if (isset($request->status)) {
            $company->status = $request->status;
        }

        $companyResponse = $company->save();

        if (!$companyResponse) {
            throw new Exception('Company Update Failed');
        }

        return $companyResponse;
    }

    public function deleteCompany($id)
    {
        $company = Company::find($id);

        if (! $company->delete() ) {
            throw new Exception('Company Delete Failed');
        }

        return true;
    }

}
