<?php

namespace App\Manager;

use App\Validator\RubricValidator;
use Doctrine\ORM\EntityManagerInterface;

class RubricManager extends ManagerAbstract
{
    public function __construct(EntityManagerInterface $manager, RubricValidator $validator)
    {
        parent::__construct($manager, $validator);
    }
}
