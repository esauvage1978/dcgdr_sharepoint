<?php

namespace App\Manager;

use App\Validator\PictureValidator;
use Doctrine\ORM\EntityManagerInterface;

class PictureManager extends ManagerAbstract
{
    public function __construct(EntityManagerInterface $manager, PictureValidator $validator)
    {
        parent::__construct($manager, $validator);
    }
}
