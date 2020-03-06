<?php

namespace App\Manager;

use App\Validator\UnderRubricValidator;
use Doctrine\ORM\EntityManagerInterface;

class UnderRubricManager extends ManagerAbstract
{
    public function __construct(EntityManagerInterface $manager, UnderRubricValidator $validator)
    {
        parent::__construct($manager, $validator);
    }
}
