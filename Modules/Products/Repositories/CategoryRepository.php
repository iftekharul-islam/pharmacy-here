<?php


namespace Modules\Products\Repositories;

use Dingo\Api\Exception\ValidationHttpException;
use Illuminate\Support\Str;
use Modules\Products\Entities\Model\Category;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryRepository
{
    public function all()
    {
        return Category::paginate(10);
    }

    public function findById($id)
    {
        return Category::find($id);
    }

    public function create($data)
    {
        $slug = Str::of($data->get('name'))->slug('-');

        $existingCategory = Category::where('slug', $slug)->first();

        if ($existingCategory) {
            throw new ValidationHttpException('Caregory already exists.');
        }

        return Category::create([
            'name' => $data->get('name'),
            'slug' => $slug,
            'status' => $data->get('status')
        ]);

    }

    public function findBySlug($slug)
    {
        return Category::where('slug', $slug)->first();
    }

    public function delete($id)
    {
        $category = Category::find($id);

        if (! $category) {
            throw new NotFoundHttpException('Category not found');
        }

        return $category->delete();
    }

}
