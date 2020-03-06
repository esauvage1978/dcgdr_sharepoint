<?php

namespace App\Repository;


use App\Entity\UnderRubric;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UnderRubric|null find($id, $lockMode = null, $lockVersion = null)
 * @method UnderRubric|null findOneBy(array $criteria, array $orderBy = null)
 * @method UnderRubric[]    findAll()
 * @method UnderRubric[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UnderRubricRepository extends ServiceEntityRepository
{
    const ALIAS='ur';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UnderRubric::class);
    }
    public function findAllForAdmin()
    {
        return $this->createQueryBuilder(self::ALIAS)
            ->select(
                self::ALIAS,
                PictureRepository::ALIAS,
                UnderThematicRepository::ALIAS,
                ThematicRepository::ALIAS,
                RubricRepository::ALIAS
            )
            ->leftJoin(self::ALIAS.'.picture',PictureRepository::ALIAS)
            ->leftJoin(self::ALIAS.'.underThematic',UnderThematicRepository::ALIAS)
            ->leftJoin(self::ALIAS.'.rubric',RubricRepository::ALIAS)
            ->leftJoin(RubricRepository::ALIAS.'.thematic',ThematicRepository::ALIAS)
            ->orderBy(self::ALIAS.'.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
