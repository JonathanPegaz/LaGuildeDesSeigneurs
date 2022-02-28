<?php

namespace App\Service;

use App\Entity\Player;

interface PlayerServiceInterface
{
    /**
     * create the player
     */
    public function create(string $data);
    /**
     * Checks if the entity has been well filled
     */
    public function isEntityFilled(Player $player);
    /**
     * Submits the data to hydrate the object
     */
    public function submit(Player $player, $formName, $data);
    /**
     * Gets all the players
     */
    public function getAll();
    /**
    * Modifies the player
    */
    public function modify(Player $player, string $data);
    /**
    * Delete the player
    */
    public function delete(Player $player);
}