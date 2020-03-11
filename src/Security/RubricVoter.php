<?php

namespace App\Security;

use App\Entity\Rubric;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class RubricVoter extends Voter
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
        if (null !== $subject and !$subject instanceof Rubric) {
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

        /** @var Rubric $rubric */
        $rubric = $subject;

        switch ($attribute) {
            case self::READ:
                return $this->canRead($rubric, $user);
            case self::UPDATE:
                return $this->canUpdate($rubric, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    public function canRead(Rubric $rubric, User $user)
    {
        if ($this->security->isGranted('ROLE_GESTIONNAIRE')) {
            return true;
        }

        if ($rubric->getShowAll()) {
            return true;
        }

        foreach ($rubric->getReaders() as $corbeille) {
            if (in_array($user, $corbeille->getUsers()->toArray())) {
                return true;
            }
        }

        return $this->canUpdate($rubric, $user);
    }

    public function canUpdate(Rubric $rubric, User $user)
    {
        if ($this->security->isGranted('ROLE_GESTIONNAIRE')) {
            return true;
        }

        foreach ($rubric->getWriters() as $corbeille) {
            if (in_array($user, $corbeille->getUsers()->toArray())) {
                return true;
            }
        }

        return false;
    }

}
