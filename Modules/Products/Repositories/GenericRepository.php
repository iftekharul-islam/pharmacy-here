<?php


namespace Modules\Products\Repositories;

use Modules\Products\Entities\Model\Generic;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GenericRepository
{
    public function all()
    {
        return Generic::get();
    }

    public function create($request)
    {
        $data = $request->only('name', 'status');

        return Generic::create($data);
    }

    public function get($id)
    {
        return Generic::find($id);
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

        $generic->save();
        return $generic;
    }

    public function delete($id)
    {
        $generic = Generic::find($id);

        if (! $generic ) {
            throw new NotFoundHttpException('Generic not found');
        }

        return $generic->delete();
    }


}
