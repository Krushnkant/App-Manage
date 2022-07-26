<?php

namespace Database\Seeders;

use App\Models\Field;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FieldsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fields')->truncate();
        Field::create([
            'title' => 'Textbox',
            'type' => 'textbox',
            'selection_type' => null,
            'estatus' => 1,
        ]);

        Field::create([
            'title' => 'Image',
            'type' => 'file',
            'selection_type' => null,
            'estatus' => 1,
        ]);

        Field::create([
            'title' => 'Multi Image',
            'type' => 'multi-file',
            'selection_type' => null,
            'estatus' => 1,
        ]);
        
    }
}
