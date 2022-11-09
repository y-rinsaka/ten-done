<?php

use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Account::create([
            'name' => 'わだどん',
            'taiko_id' => '511025692968',
            'taiko_id_verified_at' => null,
            'pref_id' => 2,
            'rank_id' => 2,
            'password' => Hash::make('511025692968')

            ]);
        \App\Account::create([
            'name' => 'かっちゃん',
            'taiko_id' => '670211332710',
            'taiko_id_verified_at' => null,
            'pref_id' => 12,
            'rank_id' => 4,
            'password' => Hash::make('670211332710')
            ]);        
        \App\Account::create([
            'name' => 'るっはー！',
            'taiko_id' => '616965172364',
            'taiko_id_verified_at' => null,
            'pref_id' => 5,
            'rank_id' => 4,
            'password' => Hash::make('616965172364')

            ]);
        \App\Account::create([
            'name' => 'て',
            'taiko_id' => '144180195243',
            'taiko_id_verified_at' => null,
            'pref_id' => 28,
            'rank_id' => 5,
            'password' => Hash::make('144180195243')
            ]);      
        \App\Account::create([
            'name' => 'ゆず',
            'taiko_id' => '138723196610',
            'taiko_id_verified_at' => null,
            'pref_id' => 3,
            'rank_id' => 3,
            'password' => Hash::make('138723196610')
            ]);
        \App\Account::create([
            'name' => 'あむっち',
            'taiko_id' => '335854019439',
            'taiko_id_verified_at' => null,
            'pref_id' => 16,
            'rank_id' => 4,
            'password' => Hash::make('335854019439')
            ]);        
        \App\Account::create([
            'name'  => 'らーあわ',
            'taiko_id' => '274788522508',
            'taiko_id_verified_at' => null,
            'pref_id' => 13,
            'rank_id' => 4,
            'password' => Hash::make('274788522508')

            ]);
        \App\Account::create([
            'name' => 'しんりゅう',
            'taiko_id' => '762579702864',
            'taiko_id_verified_at' => null,
            'pref_id' => 47,
            'rank_id' => 2,
            'password' => Hash::make('762579702864')
            ]);    
        
    }
}
