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
            'name' => 'SS'
            ]);   
        \App\Difficulty::create([
            'id' => 2,
            'name' => 'S+'
            ]);   
        \App\Difficulty::create([
            'id' => 3,
            'name' => 'S'
            ]);   
        \App\Difficulty::create([
            'id' => 4,
            'name' => 'S個人差'
            ]);  
        \App\Difficulty::create([
            'id' => 5,
            'name' => 'A+'
            ]);   
        \App\Difficulty::create([
            'id' => 6,
            'name' => 'A+個人差'
            ]); 
        \App\Difficulty::create([
            'id' => 7,
            'name' => 'A'
            ]);   
        \App\Difficulty::create([
            'id' => 8,
            'name' => 'A個人差'
            ]);   
        \App\Difficulty::create([
            'id' => 9,
            'name' => 'B'
            ]);   
        \App\Difficulty::create([
            'id' => 10,
            'name' => 'B個人差'
            ]);  
        \App\Difficulty::create([
            'id' => 11,
            'name' => 'C'
            ]);   
        \App\Difficulty::create([
            'id' => 12,
            'name' => 'C個人差'
            ]);
        \App\Difficulty::create([
            'id' => 13,
            'name' => 'D'
            ]);   
        \App\Difficulty::create([
            'id' => 14,
            'name' => 'D個人差'
            ]);
        \App\Difficulty::create([
            'id' => 15,
            'name' => 'E'
            ]);   
        \App\Difficulty::create([
            'id' => 16,
            'name' => 'E個人差'
            ]);
        \App\Difficulty::create([
            'id' => 17,
            'name' => 'F'
            ]);   
        \App\Difficulty::create([
            'id' => 18,
            'name' => '未分類'
            ]);
    }
}
