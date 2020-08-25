<?php 

namespace App\Imports;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Modules\User\Entities\Models\User;
use Spatie\Permission\Models\Role;

class PharmacyImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        echo "importing...\n";
        $role = Role::where('name', 'pharmacy')->first();
        //DELETE PREVIOUS PHARMACY USERS
        $user = User::where('is_pharmacy', 1)->forceDelete();
        foreach ($rows as $row) 
        {
            if (isset($row['mobile']) && $row['mobile'] != null) {
                
                $user = User::firstOrNew([
                    'phone_number' => '0'.$row['mobile'],
                ]);

                $user->name = $row['name'];
                $user->email = $row['email'];
                $user->dob = $row['dob'];
                $user->gender = $row['gender'];
                $user->status = 1;
                $user->is_pharmacy = 1;
                $user->phone_number = '0'.$row['mobile'];
                $user->password = Hash::make('12345678');
                $user->save();
                if($role) { $user->assignRole($role); }
                echo $user->name . "\n";
            }
        }
        echo "done...\n";
    }
}