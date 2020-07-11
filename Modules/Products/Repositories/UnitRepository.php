<?php


namespace Modules\Products\Repositories;

use Illuminate\Support\Str;
use Modules\Products\Entities\Model\Unit;

class UnitRepository
{
    public function all()
    {
        $units = Unit::all();

        return response()->json([
            'error' => false,
            'data' => $units
        ]);
    }

    public function findById($id)
    {
        $unit = Unit::find($id);

        return response()->json([
            'error' => false,
            'data' => $unit
        ]);
    }

    public function create($data)
    {
        $slug = Str::of($data->get('name'))->slug('-');

        $existingUnit = Unit::where('slug', $slug)->first();

        if ($existingUnit) {
            return response()->json([
                'error' => true,
                'message' => "Unit already exist."
            ]);
        }

        $category = Unit::create([
            'name' => $data->get('name'),
            'slug' => $slug,
            'status' => $data->get('status')
        ]);

        return response()->json([
            'error' => false,
            'data' => $category
        ]);
    }

    public function findBySlug($slug)
    {
        $unit = Unit::where('slug', $slug)->first();

        return response()->json([
            'error' => false,
            'data' => $unit
        ]);
    }

    public function delete($id)
    {
        $unit = Unit::find($id);

        if ($unit) {
            $unit->delete();

            return response()->json([
                'error' => false,
                'message' => 'Unit deleted successfully'
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Unit Not found'
        ]);
    }

}
