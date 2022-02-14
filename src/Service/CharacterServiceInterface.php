<?php

namespace App\Service;

use App\Entity\Character;

interface CharacterServiceInterface
{
    /**
     * create the character
     */
    public function create();
    /**
     * Gets all the characters
     */
    public function getAll();
    /**
    * Modifies the character
    */
    public function modify(Character $character);
    /**
    * Delete the character
    */
    public function delete(Character $character);
}