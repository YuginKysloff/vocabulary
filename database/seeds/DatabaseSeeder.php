<?php

use Illuminate\Database\Seeder;
use App\Algorithm;
use App\Word;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Fill algorithms table
        $algorithm = ['md5', 'crc32', 'sha256', 'ripemd256', 'gost'];
        for($i = 0; $i < 5; $i++) {
            Algorithm::create([
                'name' => $algorithm[$i],
            ]);
        }
        // Fill vocabulary table
        $vocabulary = ['hello', 'world', 'glad', 'represent', 'you', 'solution', 'encode', 'word', 'few', 'type', 'hash', 'start', 'should', 'login', 'register'];
        for($i = 0; $i < 15; $i++) {
            Word::create([
                'word' => $vocabulary[$i],
            ]);
        }
    }
}
