<?php

namespace App\Service;

use App\Entity\Character;

interface CharacterServiceInterface
{
    /**
     * create the character
     */
    public function create(string $data);
    /**
     * Checks if the entity has been well filled
     */
    public function isEntityFilled(Character $character);
    /**
     * Submits the data to hydrate the object
     */
    public function submit(Character $character, $formName, $data);
    /**
     * Gets all the characters
     */
    public function getAll();
    /**
     * Gets the characters who have the intelligence equal supérioir
     */
    public function getAboveIntelligence(int $number);
    /**
    * Modifies the character
    */
    public function modify(Character $character, string $data);
    /**
    * Delete the character
    */
    public function delete(Character $character);
    /**
    * Gets images randomly using kind
    */
    public function getImages(int $number, ?string $kind = null);
    /**
    * Creates the character from html form
    */
    public function createFromHtml(Character $character);
    /**
    * Modifies the character from html form
    */
    public function modifyFromHtml(Character $character);
    /**
     * Serialize the object(s)
     */
    public function serializeJson($data);
    /*
    * Gets the characters by Life
    */
    public function getByLife( string $data);

    /*
    * Gets the characters by Knowledge
    */
    public function getByKnowledge( string $data);

    /*
    * Gets the characters by Caste
    */
    public function getByCaste( string $data);
}
