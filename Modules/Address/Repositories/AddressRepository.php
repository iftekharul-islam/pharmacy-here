<?php


namespace Modules\Address\Repositories;

use Dingo\Api\Exception\DeleteResourceFailedException;
use Modules\Address\Entities\CustomerAddress;
use PhpParser\Node\Scalar\MagicConst\Dir;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AddressRepository
{
    public function get($user_id)
    {
        return CustomerAddress::where('user_id', $user_id)->get();
    }

    public function create($data, $user_id)
    {
        return CustomerAddress::create([
            'address' => $data->get('address'),
            'area_id' => $data->get('area_id'),
            'user_id' => $user_id
        ]);
    }

    public function findById($id)
    {
        return CustomerAddress::find($id);
    }


    public function update($request, $id)
    {
        $address = CustomerAddress::find($id);

        if (!$address) {
            throw new NotFoundHttpException('Address not found');
        }

        if (isset($request->address)) {
            $address->address = $request->address;
        }

        if (isset($request->area_id)) {
            $address->area_id = $request->area_id;
        }

        $address->save();

        return $address;
    }

    public function delete($id)
    {
        $address = CustomerAddress::find($id);

        if (!$address) {
            throw new DeleteResourceFailedException('Address not found');
        }

        $address->delete();

        return responseData('Address has been deleted.');
    }

    public function getCustomerAddress($user_id)
    {
        return CustomerAddress::with('area.thana.district')->where('user_id', $user_id)->get();
    }
}
