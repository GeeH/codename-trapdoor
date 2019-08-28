<?php

namespace Tests\Unit;

use App\Player;
use Tests\TestCase;

class PlayerTest extends TestCase
{

    public function testCreatingNewPlayerAddsDefaultCardsToDeck()
    {
        $player = new Player();
        self::assertSame(8, $player->deck->count());
        self::assertSame(1001, $player->deck->first()->id);
        self::assertSame(2001, $player->deck->last()->id);
    }

    public function testPrototypeHowCardsAreCopiedFromDeckToHand()
    {
        $player = new Player();

        // new combat starts
        $player->drawPile = $player->deck->shuffle();
        self::assertSame(8, $player->drawPile->count());

        // new round
        $player->hand = $player->drawPile->slice(0, 4);
        self::assertSame(4, $player->hand->count());

        // end of round
        while ($card = $player->hand->shift()) {
            $player->discardPile->add($card);
        }
        self::assertSame(4, $player->discardPile->count());
        self::assertSame(0, $player->hand->count());

    }

}
