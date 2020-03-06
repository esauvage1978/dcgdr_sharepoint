<?php

namespace App\Manager;

use App\Validator\ThematicValidator;
use Doctrine\ORM\EntityManagerInterface;

class ThematicManager extends ManagerAbstract
{
    public function __construct(EntityManagerInterface $manager, ThematicValidator $validator)
    {
        parent::__construct($manager, $validator);
    }
}
