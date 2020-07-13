<?php


namespace Modules\Products\Repositories;

use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\ValidationHttpException;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Str;
use Modules\Products\Entities\Model\Category;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

        return $category;
    }

    public function create($data)
    {
        $slug = Str::of($data->get('name'))->slug('-');

        $existingCategory = Category::where('slug', $slug)->first();

        if ($existingCategory) {
            throw new ValidationHttpException('Caregory already exists.');
        }

        $category = Category::create([
            'name' => $data->get('name'),
            'slug' => $slug,
            'status' => $data->get('status')
        ]);

        return $category;
    }

    public function findBySlug($slug)
    {
        $category = Category::where('slug', $slug)->first();

        if (!$category) {
            throw new NotFoundHttpException('Product Not Found');
        }

        return $category;
    }

    public function delete($id)
    {
        $category = Category::find($id);

        if (!$category->delete() ) {
            throw new DeleteResourceFailedException('Generic Delete Failed');
        }

        return $category;
    }

}
