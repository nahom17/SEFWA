<?php

namespace Database\Seeders;

use App\Models\Club;
use Illuminate\Database\Seeder;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clubs = [
            'Dekemhare','Mendefera',' Keren' ,' Adi_keyh',
            ' Senafe',' Segeneyti',' Asmara','  Mayani',
            ' Barentu',' Meraguz',' Adi_quala',
        ];

        foreach ($clubs as $club) {
            Club::create([
                'name' => $club,
            ]);
        }
    }
}