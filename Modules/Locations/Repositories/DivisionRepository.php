<?php


namespace Modules\Locations\Repositories;

use Dingo\Api\Exception\DeleteResourceFailedException;
use Modules\Locations\Entities\Models\Division;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DivisionRepository
{
    public function get()
    {
        return Division::orderby('name', 'asc')->get();
    }

    public function create($data)
    {
        return Division::create([
            'name' => $data->get('name'),
            'bn_name' => $data->get('bn_name'),
            'status' => $data->get('status')
        ]);
    }

    public function findById($id)
    {
        return Division::find($id);
    }


    public function update($request, $id)
    {
        $district = Division::find($id);

        if (!$district) {
            throw new NotFoundHttpException('Division not found');
        }

        if (isset($request->name)) {
            $district->name = $request->name;
        }

        if (isset($request->bn_name)) {
            $district->bn_name = $request->bn_name;
        }
        
        if (isset($request->status)) {
            $district->status = $request->status;
        }

        $district->save();
        return $district;
    }

    public function delete($id)
    {
        $district = Division::find($id);

        if (! $district->delete() ) {
            throw new DeleteResourceFailedException('Division not found');
        }

        return responseData('Division has been deleted.');
    }
}
