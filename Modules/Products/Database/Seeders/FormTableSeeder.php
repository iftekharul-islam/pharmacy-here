<?php

namespace Modules\Products\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Products\Entities\Model\Form;

class FormTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Form::create([
            'name' => 'Form One',
            'slug' => Str::slug('Form One'),
            'status' => true
        ]);

        Form::create([
            'name' => 'Form Two',
            'slug' => Str::slug('Form Two'),
            'status' => true
        ]);

        Form::create([
            'name' => 'Form Three',
            'slug' => Str::slug('Form Three'),
            'status' => true
        ]);
    }
}
