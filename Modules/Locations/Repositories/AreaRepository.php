<?php


namespace Modules\Locations\Repositories;

use Dingo\Api\Exception\DeleteResourceFailedException;
use Modules\Locations\Entities\Models\Area;
use PhpParser\Node\Scalar\MagicConst\Dir;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AreaRepository
{
    public function get()
    {
        return Area::with('thana')->orderby('name', 'asc')->paginate(20);
    }

    public function create($data)
    {
        return Area::create([
            'name' => $data->get('name'),
            'bn_name' => $data->get('bn_name'),
            'thana_id' => $data->get('thana_id'),
            'status' => $data->get('status')
        ]);
    }

    public function findById($id)
    {
        return Area::find($id);
    }


    public function update($request, $id)
    {
        $area = Area::find($id);

        if (!$area) {
            throw new NotFoundHttpException('Area not found');
        }

        if (isset($request->name)) {
            $area->name = $request->name;
        }

        if (isset($request->bn_name)) {
            $area->bn_name = $request->bn_name;
        }

        if (isset($request->thana_id)) {
            $area->thana_id = $request->thana_id;
        }

        if (isset($request->status)) {
            $area->status = $request->status;
        }

        $area->save();
        return $area;
    }

    public function delete($id)
    {
        $area = Area::find($id);

        if (! $area->delete() ) {
            throw new DeleteResourceFailedException('Area not found');
        }

        return responseData('Area has been deleted.');
    }
}
