<?php

namespace App;

use App\Exception\Game\NotEnoughCardsInDrawPileException;
use Illuminate\Support\Collection;

class Player
{
    /** @var PlayerStats */
    private $stats;

    /** @var Collection */
    private $deck;

    /** @var Collection */
    private $drawPile;

    /** @var Collection */
    private $hand;

    /** @var Collection */
    private $discardPile;

    /** @var <Int> */
    private $startingDeck = [
        1001, 1001, 1001, 1001,
        2001, 2001, 2001, 2001,
    ];

    public function __construct(
//        PlayerStats $playerStats,
//        Collection $deck,
//        Collection $drawPile,
//        Collection $hand,
//        Collection $discardPile
    )
    {
        $this->deck = new Collection();
        foreach ($this->startingDeck as $cardId) {
            $this->deck->add(
                Card::findOrFail($cardId)
            );
        }

        $this->discardPile = new Collection();
        $this->hand = new Collection();
        $this->drawPile = new Collection();
    }

    public function deck(): Collection
    {
        return $this->deck;
    }

    public function drawPile(): Collection
    {
        return $this->drawPile;
    }

    public function createDrawPileFromDeck(): void
    {
        $this->drawPile = $this->deck->shuffle();
    }

    public function draw(int $numberOfCards): void
    {
        if ($this->drawPile->count() < $numberOfCards) {
            throw new NotEnoughCardsInDrawPileException();
        }
        $this->hand = $this->drawPile->splice(0, $numberOfCards);
    }

    public function hand(): Collection
    {
        return $this->hand;
    }

    public function discardPile(): Collection
    {
        return $this->discardPile;
    }

    public function discardHand(): void
    {
        $this->discardPile->splice(
            0,
            0,
            $this->hand->all()
        );
        // cheeky... replace zero items at index zero with the hand
        // essentially this adds the third parameter to the top of the collection

        $this->hand->splice(0, $this->hand->count());
    }

}
