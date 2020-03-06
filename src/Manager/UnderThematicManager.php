<?php

namespace App\Manager;

use App\Validator\UnderThematicValidator;
use Doctrine\ORM\EntityManagerInterface;

class UnderThematicManager extends ManagerAbstract
{
    public function __construct(EntityManagerInterface $manager, UnderThematicValidator $validator)
    {
        parent::__construct($manager, $validator);
    }
}
