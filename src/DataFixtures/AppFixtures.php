<?php

namespace App\DataFixtures;

use App\Entity\Character;
use App\Entity\Player;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use DateTime;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //Characters
        $objects = array(
            'Seigneurs',
            'Dames',
            'Ennemis',
            'Ennemies',
        );

        foreach ($objects as $object) {
            $method = 'define' . $object;
            $characters = $this->$method();
            foreach ($characters as $characterName => $data) {
                $character = $this->setCharacter($object, $characterName, $data);

                $manager->persist($character);
            }
        }

        //Players
        for ($i = 1; $i < 10; $i++) {
            $player = $this->setPlayer($i);

            $manager->persist($player);

            //Links to Characters
            foreach ($objects as $object) {
                $method = 'define' . $object;
                $characters = $this->$method();

                //Defines random Characters to use
                $keys = array_keys($characters);
                shuffle($keys);
                $charactersRandom = array();
                foreach ($keys as $key) {
                    $charactersRandom[$key] = $characters[$key];
                }
                $charactersRandom = array_slice($charactersRandom, 0, mt_rand(0,2), true);
                foreach ($charactersRandom as $characterName => $data) {
                    $character = $this->setCharacter($object, $characterName, $data);
                    $character->setPlayer($player);

                    $manager->persist($character);
                }
            }

        }

        $manager->flush();
    }

    /**
     * Sets the Player
     * @return array
     */
    public function setPlayer($i)
    {
        $player = new Player();
        $player
            ->setFirstname('Firstname-' . $i)
            ->setLastname('Lastname-' . $i)
            ->setEmail('Firstname-' . $i . '.' . 'Lastname-' . $i . '@example.com')
            ->setMirian(mt_rand(100, 200))
            ->setIdentifier(hash('sha1', uniqid()))
            ->setCreation(new DateTime())
            ->setModification(new DateTime())
        ;

        return $player;
    }

    /**
     * Sets the Character with its data
     * @return array
     */
    public function setCharacter($object, $characterName, $data)
    {
        $character = new Character();
        $character
            ->setKind(substr_replace($object, '', -1))
            ->setName($characterName)
            ->setSurname($data['surname'])
            ->setCaste($data['caste'])
            ->setKnowledge($data['knowledge'])
            ->setIntelligence($data['intelligence'])
            ->setLife($data['life'])
            ->setImage('/images/' . strtolower($object) . '/' . strtolower($characterName) . '.jpg')
            ->setIdentifier(hash('sha1', uniqid()))
            ->setCreation(new DateTime())
            ->setModification(new DateTime())
        ;

        return $character;
    }





    /**
     * Defines data for the Seigneurs
     * @return array
     */
    public function defineSeigneurs() :array
    {
        return array(
            'Celeborn' => array(
                'caste' => 'Archer',
                'intelligence' => 100,
                'life' => 14,
                'surname' => "Arbre d'argent",
                'knowledge' => 'Nombres',
            ),
            'Calimehtar' => array(
                'caste' => 'Guerrier',
                'intelligence' => 90,
                'life' => 15,
                'surname' => "Guerrier de lumière",
                'knowledge' => 'Cartographie',
            ),
            'Gorthol' => array(
                'caste' => 'Chevalier',
                'intelligence' => 110,
                'life' => 13,
                'surname' => "Haume de terreur",
                'knowledge' => 'Diplomatie',
            ),
            'Elendur' => array(
                'caste' => 'Elfe',
                'intelligence' => 120,
                'life' => 12,
                'surname' => "Serviteur des étoiles",
                'knowledge' => 'Arts',
            ),
            'Anfauglith' => array(
                'caste' => 'Magicien',
                'intelligence' => 130,
                'life' => 11,
                'surname' => "Poussière d'agonie",
                'knowledge' => 'Sciences',
            ),
            'Turambar' => array(
                'caste' => 'Erudit',
                'intelligence' => 140,
                'life' => 10,
                'surname' => "Maître du destin",
                'knowledge' => 'Lettres',
            )
        );
    }

    /**
     * Defines data for the Dames
     * @return array
     */
    public function defineDames(): array
    {
        return array(
            'Maeglin' => array(
                'caste' => 'Archer',
                'intelligence' => 100,
                'life' => 14,
                'surname' => 'Oeil vif',
                'knowledge' => 'Nombres',
            ),
            'Athelleen' => array(
                'caste' => 'Guerrier',
                'intelligence' => 90,
                'life' => 15,
                'surname' => 'Guerrière des flammes',
                'knowledge' => 'Cartographie',
            ),
            'Nolofinwe' => array(
                'caste' => 'Chevalier',
                'intelligence' => 110,
                'life' => 13,
                'surname' => 'Sagesse',
                'knowledge' => 'Diplomatie',
            ),
            'Eldalote' => array(
                'caste' => 'Elfe',
                'intelligence' => 120,
                'life' => 12,
                'surname' => 'Fleur elfique',
                'knowledge' => 'Arts',
            ),
            'Anardil' => array(
                'caste' => 'Magicien',
                'intelligence' => 130,
                'life' => 11,
                'surname' => 'Amie du soleil',
                'knowledge' => 'Sciences',
            ),
            'Rumil' => array(
                'caste' => 'Érudit',
                'intelligence' => 140,
                'life' => 10,
                'surname' => 'La savante',
                'knowledge' => 'Lettres',
            ),
        );
    }

    /**
     * Defines data for the Ennemies
     * @return array
     */
    public function defineEnnemies(): array
    {
        return array(
            'Feanturi'  => array(
                'caste' => 'Elfe noire',
                'intelligence' => 120,
                'life' => 12,
                'surname' => 'Maîtresse des esprits',
                'knowledge' => 'Lettres',
            ),
            'Tinuviel'  => array(
                'caste' => 'Enchanteuse',
                'intelligence' => 130,
                'life' => 10,
                'surname' => 'Fille du crépuscule',
                'knowledge' => 'Arts',
            ),
            'Firiel' => array(
                'caste' => 'Empoisonneuse',
                'intelligence' => 110,
                'life' => 13,
                'surname' => 'Femme mortelle',
                'knowledge' => 'Diplomatie',
            ),
        );
    }

    /**
     * Defines data for the Ennemis
     * @return array
     */
    public function defineEnnemis(): array
    {
        return array(
            'Gurthang'  => array(
                'caste' => 'Bourreau',
                'intelligence' => 90,
                'life' => 15,
                'surname' => 'Fer de la mort',
                'knowledge' => 'Nombres',
            ),
            'Dagnir'  => array(
                'caste' => 'Lycanthrope',
                'intelligence' => 100,
                'life' => 14,
                'surname' => 'Tourmenteur',
                'knowledge' => 'Cartographie',
            ),
            'Aranruth' => array(
                'caste' => 'Sorcier',
                'intelligence' => 140,
                'life' => 10,
                'surname' => 'Colère du roi',
                'knowledge' => 'Sciences',
            ),
        );
    }
}