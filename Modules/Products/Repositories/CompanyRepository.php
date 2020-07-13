<?php


namespace Modules\Products\Repositories;


use Dingo\Api\Exception\DeleteResourceFailedException;
use Modules\Products\Entities\Model\Company;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CompanyRepository
{
    public function all()
    {
        return Company::paginate(10);
    }

    public function create($request)
    {
        $data = $request->only('name', 'status');

        return Company::create($data);
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

        return $company->save();


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
        $company =  Company::find($id);

        if (! $company) {
            throw new NotFoundHttpException('Company not found');
        }

        return $company->delete();
    }

}
