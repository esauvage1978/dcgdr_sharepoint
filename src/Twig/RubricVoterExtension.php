<?php

namespace App\Twig;

use App\Entity\Rubric;
use App\Entity\User;
use App\Security\RubricVoter;
use Doctrine\Common\Collections\Collection;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Symfony\Component\Security\Core\Security;

class RubricVoterExtension extends AbstractExtension
{
    /**
     * @var RubricVoter
     */
    private $rubricVoter;

    /**
     * @var Security
     */
    private $security;

    public function __construct(
        Security $security,
        RubricVoter $rubricVoter
    ) {
        $this->security = $security;
        $this->rubricVoter=$rubricVoter;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('rubricCanRead', [$this, 'rubricCanRead']),
            new TwigFilter('rubricCanUpdate', [$this, 'rubricCanUpdate']),
        ];
    }

    public function rubricCanRead(Rubric $rubric)
    {
        /** @var User $user */
        $user = $this->security->getToken()->getUser();

        return $this->rubricVoter->canRead($rubric, $user);
    }

    public function rubricCanUpdate(Rubric $rubric)
    {
        /** @var User $user */
        $user = $this->security->getToken()->getUser();

        return $this->rubricVoter->canUpdate($rubric, $user);
    }
}
