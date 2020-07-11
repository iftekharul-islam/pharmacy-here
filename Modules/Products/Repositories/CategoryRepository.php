<?php


namespace Modules\Products\Repositories;

use Illuminate\Support\Str;
use Modules\Products\Entities\Model\Category;

class CategoryRepository
{
    public function all()
    {
        $categories = Category::all();

        return response()->json([
            'error' => false,
            'data' => $categories
        ]);
    }

    public function findById($id)
    {
        $category = Category::find($id);

        return response()->json([
            'error' => false,
            'data' => $category
        ]);
    }

    public function create($data)
    {
        $slug = Str::of($data->get('name'))->slug('-');


        $existingCategory = Category::where('slug', $slug)->first();
//        return $existingCategory;

        if ($existingCategory) {
            return response()->json([
                'error' => true,
                'message' => "Category already exist."
            ]);
        }

        $category = Category::create([
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
        $category = Category::where('slug', $slug)->first();

        return response()->json([
            'error' => false,
            'data' => $category
        ]);
    }

    public function delete($id)
    {
        $category = Category::find($id)->delete();

        if ($category) {
            $category->delete();

            return response()->json([
                'error' => false,
                'message' => 'Category deleted successfully'
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Category not found.'
        ]);
    }

}
