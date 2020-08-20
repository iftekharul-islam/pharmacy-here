<?php


namespace Modules\Locations\Repositories;

use Dingo\Api\Exception\DeleteResourceFailedException;
use Modules\Locations\Entities\Models\District;
use PhpParser\Node\Scalar\MagicConst\Dir;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DistrictRepository
{
    public function get()
    {
        // return District::with('thanas.areas')->get();
        return District::orderby('name', 'asc')->paginate(20);
    }

    public function create($data)
    {
        return District::create([
            'name' => $data->get('name'),
            'bn_name' => $data->get('bn_name'),
            'division_id' => $data->get('division_id'),
            'status' => $data->get('status')
        ]);
    }

    public function findById($id)
    {
        return District::find($id);
    }


    public function update($request, $id)
    {
        $district = District::find($id);

        if (!$district) {
            throw new NotFoundHttpException('District not found');
        }

        if (isset($request->name)) {
            $district->name = $request->name;
        }

        if (isset($request->bn_name)) {
            $district->bn_name = $request->bn_name;
        }

        if (isset($request->division_id)) {
            $district->division_id = $request->division_id;
        }

        if (isset($request->status)) {
            $district->status = $request->status;
        }

        $district->save();
        return $district;
    }

    public function delete($id)
    {
        $district = District::find($id);

        if (! $district->delete() ) {
            throw new DeleteResourceFailedException('District not found');
        }

        return responseData('District has been deleted.');
    }
}
