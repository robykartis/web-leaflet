<?php

namespace Database\Seeders;

use App\Models\Maps;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MapsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Maps::create([
            'title' => 'Pekanbaru',
            'description' => 'test',
            'lat' => '0.4203327',
            'lng' => '101.5239191'
        ]);
        Maps::create([
            'title' => 'Mal Ska',
            'description' => 'test mal ska',
            'lat' => '0.4996034',
            'lng' => '101.3939995'
        ]);
        Maps::create([
            'title' => 'Bandara',
            'description' => 'test bandara',
            'lat' => '0.4851844',
            'lng' => '101.409964'
        ]);
    }
}
