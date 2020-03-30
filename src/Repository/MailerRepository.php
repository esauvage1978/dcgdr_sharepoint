<?php

namespace App\Repository;

use App\Entity\Mailer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Mailer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mailer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mailer[]    findAll()
 * @method Mailer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MailerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mailer::class);
    }
}
