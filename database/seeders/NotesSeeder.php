<?php

namespace Database\Seeders;

use App\Models\Note;
use Illuminate\Database\Seeder;

class NotesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $colors = ['#ffffff', '#d9b2c7', '#000000', '#b9b9b9', '#a3a3', '#f77777', '#f5d9a5', '#a5d4a6'];
        foreach ($colors as $key => $color) {
            Note::create([
                'user_id' => 2,
                'title' => 'Anotação ' . ($key + 1),
                'content' => 'Texto da anotação.',
                'color' => $color,
            ]);
            if ($key < 3) {
                Note::create([
                    'user_id' => 3,
                    'title' => 'Anotação ' . ($key + 1),
                    'content' => 'Texto da anotação.',
                    'color' => $color,
                ]);
            }
        }
    }
}
