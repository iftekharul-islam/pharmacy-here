<?php


namespace Modules\Products\Repositories;


use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Modules\Products\Entities\Model\Company;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CompanyRepository
{
    public function all()
    {
        return Company::all();
    }

    public function create($request)
    {
        $data = $request->only('name', 'status');

        $company = Company::create($data);

        if (! $company) {
            throw new StoreResourceFailedException('Company Create failed');
        }

        return $company;
    }

    public function update($request, $id)
    {
        $company = Company::find($id);

        if (!$company) {
            throw new NotFoundHttpException('Company not found');
        }

        if (isset($request->name)) {
            $company->name = $request->name;
        }

        if (isset($request->status)) {
            $company->status = $request->status;
        }

        $companyResponse = $company->save();

        if (! $companyResponse) {
            throw new UpdateResourceFailedException('Company not found');
        }

        return responseData('Company has been updated.');;
    }

    public function delete($id)
    {
        $company = Company::find($id);

        if (! $company->delete() ) {
            throw new DeleteResourceFailedException('Company not found');
        }

        return responseData('Company has been deleted.');
    }

    public function get($id)
    {
        $company = Company::find($id);

        if (! $company ) {
            throw new NotFoundHttpException('Company Not Found');
        }

        return $company;
    }

}
