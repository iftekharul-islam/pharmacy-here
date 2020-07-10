<?php


namespace Modules\Products\Repositories;

use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Modules\Products\Entities\Model\Generic;
use Modules\Products\Entities\Model\Company;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GenericRepository
{
    public function all()
    {
        return Generic::all();
    }

    public function create($request)
    {
        $data = $request->only('name', 'status');

        $generic = Generic::create($data);

        if (! $generic) {
            throw new StoreResourceFailedException('Generic Create failed');
        }

        return $generic;
    }

    public function update($request, $id)
    {
        $generic = Generic::find($id);

        if (! $generic) {
            throw new NotFoundHttpException('Generic not found');
        }

        if (isset($request->name)) {
            $generic->name = $request->name;
        }

        if (isset($request->status)) {
            $generic->status = $request->status;
        }

        $genericResponse = $generic->save();

        if (!$genericResponse) {
            throw new UpdateResourceFailedException('Company Update Failed');
        }

        return $genericResponse;
    }

    public function delete($id)
    {
        $generic = Generic::find($id);

        if (! $generic->delete() ) {
            throw new NotFoundHttpException('Company Delete Failed');
        }

        return true;
    }

    public function get($id)
    {
        $generic = Generic::find($id);

        if (! $generic ) {
            throw new NotFoundHttpException('Generic Not Found');
        }

        return $generic;
    }
}
