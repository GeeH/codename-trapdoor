<?php

namespace App;

use Illuminate\Support\Collection;

class Player
{
    /** @var int */
    public $maxHealth = 50;

    /** @var int */
    public $currentHealth = 50;

    /** @var int */
    public $maxEnergy = 3;

    /** @var int */
    public $currentEnergy = 3;

    /** @var int */
    public $maxDefense = 99999;

    /** @var int */
    public $currentDefense = 0;

    /** @var Collection  */
    public $deck;

    /** @var Collection */
    public $drawPile;

    /** @var Collection */
    public $hand;

    /** @var Collection */
    public $discardPile;

    /** @var <Int> */
    private $startingDeck = [
        1001, 1001, 1001, 1001,
        2001, 2001, 2001, 2001,
    ];

    public function __construct()
    {
        $this->deck = new Collection();
        foreach($this->startingDeck as $cardId) {
            $this->deck->add(
                Card::findOrFail($cardId)
            );
        }

        $this->discardPile = new Collection();
    }

}
