<?php

namespace App\Manager;

use App\Entity\EntityInterface;
use App\Validator\BackpackValidator;
use Doctrine\ORM\EntityManagerInterface;

class BackpackManager extends ManagerAbstract
{
    public function __construct(EntityManagerInterface $manager, BackpackValidator $validator)
    {
        parent::__construct($manager, $validator);
    }

    public function initialise(EntityInterface $entity): void
    {
        $entity->setUpdateAt(new \DateTime());

        foreach ($entity->getBackpackFiles() as $backpackFile)
        {
            $backpackFile->setBackpack($entity);
        }

        foreach ($entity->getBackpackLinks() as $backpackLink)
        {
            $backpackLink->setBackpack($entity);
        }
    }


}
