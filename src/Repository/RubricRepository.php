<?php

namespace App\Repository;


use App\Entity\Rubric;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Rubric|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rubric|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rubric[]    findAll()
 * @method Rubric[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RubricRepository extends ServiceEntityRepository
{
    const ALIAS='r';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rubric::class);
    }

    public function findAllForAdmin()
    {
        return $this->createQueryBuilder(self::ALIAS)
            ->select(self::ALIAS,
                ThematicRepository::ALIAS,
                UnderRubricRepository::ALIAS,
                PictureRepository::ALIAS
                )
            ->leftJoin(self::ALIAS.'.thematic',ThematicRepository::ALIAS)
            ->leftJoin(self::ALIAS.'.underRubrics',UnderRubricRepository::ALIAS)
            ->leftJoin(self::ALIAS.'.picture',PictureRepository::ALIAS)
            ->orderBy(self::ALIAS.'.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
