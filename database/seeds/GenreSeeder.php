<?php

use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Genre::create([
            'id' => 1,
            'name' => 'ポップス'
            ]);
        \App\Genre::create([
            'id' => 2,
            'name' => 'アニメ'
            ]);        
        \App\Genre::create([
            'id' => 3,
            'name' => 'キッズ'
            ]);
        \App\Genre::create([
            'id' => 4,
            'name' => 'ボーカロイド'
            ]);
        \App\Genre::create([
            'id' => 5,
            'name' => 'ゲームミュージック'
            ]);
        \App\Genre::create([
            'id' => 6,
            'name' => 'ナムコオリジナル'
            ]);
        \App\Genre::create([
            'id' => 7,
            'name' => 'バラエティ'
            ]);  
        \App\Genre::create([
            'id' => 8,
            'name' => 'クラシック'
            ]);            
    }
}
