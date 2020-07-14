<?php


namespace Modules\Products\Repositories;

use Dingo\Api\Exception\ValidationHttpException;
use Illuminate\Support\Str;
use Modules\Products\Entities\Model\Unit;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UnitRepository
{
    public function all()
    {
        return Unit::get();
    }

    public function findById($id)
    {
        $unit = Unit::find($id);

        return $unit;
    }

    public function create($data)
    {
        $slug = Str::of($data->get('name'))->slug('-');

        $existingUnit = Unit::where('slug', $slug)->first();

        if ($existingUnit) {
            throw new ValidationHttpException('Unit already exists.');
        }

        return Unit::create([
            'name' => $data->get('name'),
            'slug' => $slug,
            'status' => $data->get('status')
        ]);


    }

    public function findBySlug($slug)
    {
        $unit = Unit::where('slug', $slug)->first();

        return $slug;
    }

    public function update($request, $id)
    {
        $unit = Unit::find($id);

        if (!$unit) {
            throw new NotFoundHttpException('Unit not found');
        }

        if (isset($request->name)) {
            $unit->name = $request->name;
        }

        if (isset($request->status)) {
            $unit->status = $request->status;
        }

        return $unit->save();


    }

    public function delete($id)
    {
        $unit = Unit::find($id);

        if (! $unit) {
            throw new NotFoundHttpException('Unit not found');
        }

        return $unit->delete();
    }

}
