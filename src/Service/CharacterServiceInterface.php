<?php

namespace App\Service;

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
}