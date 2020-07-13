<?php


namespace Modules\Products\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Products\Entities\Model\Form;

class FormTransformer extends TransformerAbstract
{
    public function transform(Form $form)
    {
        return [
            'id'                        => $form->id,
            'name'                      => $form->name,
            'status'                    => $form->status,
        ];
    }
}
