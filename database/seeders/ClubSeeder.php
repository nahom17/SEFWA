<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Club;

class ClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clubs = [
            'Elabered','MayAyni',' Debarwa' ,' Mendefera',
            ' Barentu',' Adi Quala',' Asmara','  Tserona',
            ' Senafe',' Keren',' Dekemhare','  Teseney',
        ];

        foreach ($clubs as $club) {
            Club::create([
                'name' => $club,
            ]);
        }
    }
}
