<?php

namespace App\Security\Voter;

use App\Entity\Character;
use LogicException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class CharacterVoter extends Voter
{
    public const CHARACTER_CREATE = 'characterCreate';
    public const CHARACTER_DISPLAY = 'characterDisplay';
    public const CHARACTER_INDEX = 'characterIndex';
    private const ATTRIBUTES = array(
        self::CHARACTER_CREATE,
        self::CHARACTER_DISPLAY,
        self::CHARACTER_INDEX,
    );

    protected function supports($attribute, $subject)
    {
        if(null !== $subject) {
            return $subject instanceof Character && in_array($attribute, self::ATTRIBUTES);
        }
        return in_array($attribute, self::ATTRIBUTES);
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        switch ($attribute){
            case self::CHARACTER_CREATE:
                return $this->canCreate();
                break;
            case self::CHARACTER_DISPLAY:
            case self::CHARACTER_INDEX:
                return $this->canDisplay();
                break;
        }
        throw new logicException('Invalid attribute: ' . $attribute);
    }

    /**
     * Checks if is alloawed to create
     */
    private function canCreate(){
        return true;
    }

    /**
     * Checks if is alloawed to display
     */
    private function canDisplay(){
        return true;
    }
}
