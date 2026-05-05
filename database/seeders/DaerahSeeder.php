<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DaerahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $daerahs = ['Manjung', 'Taiping', 'Seri Iskandar', 'Ipoh', 'Kuala Kangsar'];

        foreach ($daerahs as $nama) {
            \App\Models\Daerah::create(['nama_daerah' => $nama]);
        }
    }
}
