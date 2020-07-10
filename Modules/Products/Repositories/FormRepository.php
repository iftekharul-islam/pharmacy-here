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
        return Form::all();
    }

    public function get($id)
    {
        $form = Form::find($id);

        if (! $form ) {
            throw new NotFoundHttpException('Form Not Found');
        }

        return $form;
    }

    public function create($request)
    {
        $data = $request->only('name', 'status');

        $form = Form::create($data);

        if (! $form) {
            throw new StoreResourceFailedException('Form Create failed');
        }

        return $form;
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

        $formResponse = $form->save();

        if (! $formResponse) {
            throw new UpdateResourceFailedException('Form not found');
        }

        return responseData('Form has been updated.');;
    }

    public function delete($id)
    {
        $form = Form::find($id);

        if (! $form->delete() ) {
            throw new DeleteResourceFailedException('Form not found');
        }

        return responseData('Form has been deleted.');
    }
}
