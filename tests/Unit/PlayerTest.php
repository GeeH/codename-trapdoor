<?php

namespace Tests\Unit;

use App\Exception\Game\NotEnoughCardsInDrawPileException;
use App\Player;
use Tests\TestCase;

class PlayerTest extends TestCase
{
    /** @var Player */
    private $player;

    public function setUp(): void
    {
        parent::setUp();
        $this->player = new Player();
    }

    public function testCreatingNewPlayerAddsDefaultCardsToDeck()
    {
        self::assertSame(8, $this->player->deck()->count());
        self::assertSame(1001, $this->player->deck()->first()->id);
        self::assertSame(2001, $this->player->deck()->last()->id);
    }

    public function testCreateDrawPileFromDeckFillsTheDrawPileWithTheShuffledDeck()
    {
        // new combat starts
        $this->player->createDrawPileFromDeck();
        self::assertSame($this->player->deck()->count(), $this->player->drawPile()->count());
        self::assertNotSame(
            $this->player->deck()->pluck('id')->all(),
            $this->player->drawPile()->pluck('id')->all()
        );
    }

    public function testDrawThrowsExceptionWithNotEnoughCardsInDrawPile()
    {
        self::expectException(NotEnoughCardsInDrawPileException::class);
        $this->player->draw(104);
    }

    public function testDrawAddsCardsToDeckWithCardsInDrawPile()
    {
        $this->player->createDrawPileFromDeck();
        $this->player->draw(4);
        self::assertSame(4, $this->player->hand()->count());
        self::assertSame(4, $this->player->drawPile()->count());
    }

    public function testDiscardingHandMovesHandToTopOfDiscardPileWithEmptyDiscardPile()
    {
        $this->player->createDrawPileFromDeck();
        $this->player->draw(4);
        $this->player->discardHand();
        self::assertSame(4, $this->player->discardPile()->count());
        self::assertSame(0, $this->player->hand()->count());
    }

    public function testDiscardingHandMovesHandToTopOfDiscardPileWithNotEmptyDiscardPile()
    {
        $this->player->createDrawPileFromDeck();
        $this->player->draw(2);
        $this->player->discardHand();
        $this->player->draw(3);
        $this->player->discardHand();
        self::assertSame(5, $this->player->discardPile()->count());
        self::assertSame(0, $this->player->hand()->count());
    }


}
