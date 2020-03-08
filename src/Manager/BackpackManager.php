<?php

namespace App\Manager;

use App\Validator\BackpackValidator;
use Doctrine\ORM\EntityManagerInterface;

class BackpackManager extends ManagerAbstract
{
    public function __construct(EntityManagerInterface $manager, BackpackValidator $validator)
    {
        parent::__construct($manager, $validator);
    }
}
