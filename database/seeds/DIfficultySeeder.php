<?php

use Illuminate\Database\Seeder;

class DIfficultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Difficulty::create([
            'id' => 1,
            'difficulty' => 'SS'
            ]);   
        \App\Difficulty::create([
            'id' => 2,
            'difficulty' => 'S+'
            ]);   
        \App\Difficulty::create([
            'id' => 3,
            'difficulty' => 'S'
            ]);   
        \App\Difficulty::create([
            'id' => 4,
            'difficulty' => 'S個人差'
            ]);  
        \App\Difficulty::create([
            'id' => 5,
            'difficulty' => 'A+'
            ]);   
        \App\Difficulty::create([
            'id' => 6,
            'difficulty' => 'A+個人差'
            ]); 
        \App\Difficulty::create([
            'id' => 7,
            'difficulty' => 'A'
            ]);   
        \App\Difficulty::create([
            'id' => 8,
            'difficulty' => 'A個人差'
            ]);   
        \App\Difficulty::create([
            'id' => 9,
            'difficulty' => 'B'
            ]);   
        \App\Difficulty::create([
            'id' => 10,
            'difficulty' => 'B個人差'
            ]);  
        \App\Difficulty::create([
            'id' => 11,
            'difficulty' => 'C'
            ]);   
        \App\Difficulty::create([
            'id' => 12,
            'difficulty' => 'C個人差'
            ]);
        \App\Difficulty::create([
            'id' => 13,
            'difficulty' => 'D'
            ]);   
        \App\Difficulty::create([
            'id' => 14,
            'difficulty' => 'D個人差'
            ]);
        \App\Difficulty::create([
            'id' => 15,
            'difficulty' => 'E'
            ]);   
        \App\Difficulty::create([
            'id' => 16,
            'difficulty' => 'E個人差'
            ]);
        \App\Difficulty::create([
            'id' => 17,
            'difficulty' => 'F'
            ]);   
        \App\Difficulty::create([
            'id' => 18,
            'difficulty' => '未分類'
            ]);
    }
}
