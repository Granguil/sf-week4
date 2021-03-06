<?php
namespace App\Security;

use App\Entity\User;
use App\Entity\House;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class HouseVoter extends Voter
{
    const EDIT = 'edit';

    public function __construct(private Security $security)
    {
    }

    protected function supports(string $attribute, $subject): bool
    {
        if (!in_array($attribute, [self::EDIT])) {
            return false;
        }

        if (!$subject instanceof House) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }
        
        $house = $subject;

        switch ($attribute) {
            
            case self::EDIT:
                return $this->canEdit($house, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

   

    private function canEdit(House $house, User $user): bool
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        return $user === $house->getOwner() ;
    }
}