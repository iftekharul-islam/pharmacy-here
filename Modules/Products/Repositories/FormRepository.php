<?php


namespace Modules\Products\Repositories;


use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Modules\Products\Entities\Model\Form;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FormRepository
{
    public function all()
    {
        return Form::paginate(10);
    }

    public function get($id)
    {
        return Form::find($id);
    }

    public function create($request)
    {
        $data = $request->only('name', 'status');

        return Form::create($data);

    }

    public function update($request, $id)
    {
        $form = Form::find($id);

        if (!$form) {
            throw new NotFoundHttpException('Company not found');
        }

        if (isset($request->name)) {
            $form->name = $request->name;
        }

        if (isset($request->status)) {
            $form->status = $request->status;
        }

        return $form->save();

    }

    public function delete($id)
    {
        $form = Form::find($id);

        if (! $form ) {
            throw new NotFoundHttpException('Form not found');
        }

        return $form->delete();
    }
}
