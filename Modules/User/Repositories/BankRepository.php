<?php


namespace Modules\User\Repositories;



use Modules\User\Entities\Models\BankName;

class BankRepository
{
    public function all()
    {
        return BankName::where('status', 1)->orderby('bank_name', 'asc')->paginate(20);
    }

    public function allBankNames()
    {
        return BankName::where('status', 1)->orderby('bank_name', 'asc')->get();
    }

    public function get($id)
    {
        return BankName::find($id);
    }

    public function create($request) {
        $data = $request->only('bank_name', 'bn_bank_name', 'status');

        return BankName::create($data);
    }

    public function delete($id)
    {
        $data = BankName::find($id);

        return $data->delete();
    }

    public function update($request, $id)
    {
        $data = BankName::find($id);

        if (isset($request->bank_name)) {
            $data->bank_name = $request->bank_name;
        }
        if (isset($request->bn_bank_name)) {
            $data->bn_bank_name = $request->bn_bank_name;
        }
        if (isset($request->status)) {
            $data->status = $request->status;
        }

        $data->save();
        return $data;
    }

}
