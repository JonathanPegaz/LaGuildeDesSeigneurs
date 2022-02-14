<?php

namespace App\Service;

use App\Entity\Player;

interface PlayerServiceInterface
{
    /**
     * create the player
     */
    public function create();
    /**
     * Gets all the players
     */
    public function getAll();
    /**
    * Modifies the player
    */
    public function modify(Player $player);
    /**
    * Delete the player
    */
    public function delete(Player $player);
}