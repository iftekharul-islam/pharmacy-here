<?php 

namespace App\Imports;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Modules\User\Entities\Models\User;

class PharmacyImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            if (isset($row['mobile']) && $row['mobile'] != null) {
                // logger($row['name']);
                $user = User::create([
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'dob' => $row['dob'],
                    'gender' => $row['gender'],
                    'status' => 1,
                    'is_pharmacy' => 1,
                    'phone_number' => $row['mobile'],
                    'password' => Hash::make('12345678')
                ]);
                // logger($user);
            }
        }
    }
}