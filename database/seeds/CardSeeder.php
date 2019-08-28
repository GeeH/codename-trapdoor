<?php

use App\Card;
use Illuminate\Database\Seeder;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Card::query()->truncate();

        $card = new Card();
        $card->id = 1001;
        $card->name = 'Attack';
        $card->cost = 1;
        $card->attack = 5;
        $card->defense = 0;
        $card->save();

        $card = new Card();
        $card->id = 2001;
        $card->name = 'Defend';
        $card->cost = 1;
        $card->attack = 0;
        $card->defense = 4;
        $card->save();

    }
}
