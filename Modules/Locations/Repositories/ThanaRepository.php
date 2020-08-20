<?php


namespace Modules\Locations\Repositories;

use Dingo\Api\Exception\DeleteResourceFailedException;
use Modules\Locations\Entities\Models\Thana;
use PhpParser\Node\Scalar\MagicConst\Dir;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ThanaRepository
{
    public function get()
    {
        return Thana::orderby('name', 'asc')->paginate(20);
    }

    public function create($data)
    {
        return Thana::create([
            'name' => $data->get('name'),
            'bn_name' => $data->get('bn_name'),
            'district_id' => $data->get('district_id'),
            'status' => $data->get('status')
        ]);
    }

    public function findById($id)
    {
        return Thana::find($id);
    }


    public function update($request, $id)
    {
        $thana = Thana::find($id);

        if (!$thana) {
            throw new NotFoundHttpException('Thana not found');
        }

        if (isset($request->name)) {
            $thana->name = $request->name;
        }

        if (isset($request->bn_name)) {
            $thana->bn_name = $request->bn_name;
        }

        if (isset($request->district_id)) {
            $thana->district_id = $request->district_id;
        }

        if (isset($request->status)) {
            $thana->status = $request->status;
        }

        $thana->save();
        return $thana;
    }

    public function delete($id)
    {
        $district = Thana::find($id);

        if (! $district->delete() ) {
            throw new DeleteResourceFailedException('Thana not found');
        }

        return responseData('Thana has been deleted.');
    }
}
