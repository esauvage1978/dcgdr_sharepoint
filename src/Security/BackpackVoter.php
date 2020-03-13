<?php

namespace App\Security;

use App\Entity\Backpack;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class BackpackVoter extends Voter
{
    const READ = 'read';
    const UPDATE = 'update';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::READ, self::UPDATE])) {
            return false;
        }

        // only vote on Post objects inside this voter
        if (null !== $subject and !$subject instanceof Backpack) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        /** @var Backpack $backpack */
        $backpack = $subject;

        switch ($attribute) {
            case self::READ:
                return $this->canRead($backpack, $user);
            case self::UPDATE:
                return $this->canUpdate($backpack, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    public function canRead(Backpack $backpack, User $user)
    {
        if ($this->security->isGranted('ROLE_GESTIONNAIRE')) {
            return true;
        }

        if ($backpack->getShowAll()) {
            return true;
        }

        foreach ($backpack->getReaders() as $corbeille) {
            if (in_array($user, $corbeille->getUsers()->toArray())) {
                return true;
            }
        }
        foreach ($backpack->getRubric() as $rubric) {
            if ($rubric->getShowAll()) {
                return true;
            }

            foreach ($rubric->getReaders() as $corbeille) {
                if (in_array($user, $corbeille->getUsers()->toArray())) {
                    return true;
                }
            }

            foreach ($rubric->getWriters() as $corbeille) {
                if (in_array($user, $corbeille->getUsers()->toArray())) {
                    return true;
                }
            }

        }

        return $this->canUpdate($backpack, $user);
    }

    public function canUpdate(Backpack $backpack, User $user)
    {
        if ($this->security->isGranted('ROLE_GESTIONNAIRE')) {
            return true;
        }

        foreach ($backpack->getWriters() as $corbeille) {
            if (in_array($user, $corbeille->getUsers()->toArray())) {
                return true;
            }
        }

        return false;
    }

}
