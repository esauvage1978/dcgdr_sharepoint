<?php


namespace App\Repository;


use App\Dto\RubricDto;
use App\Dto\DtoInterface;
use App\Entity\Rubric;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

class RubricDtoRepository extends ServiceEntityRepository implements DtoRepositoryInterface
{
    use TraitDtoRepository;


    const ALIAS = 'r';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rubric::class);
    }

    public function countForDto(DtoInterface $dto)
    {
        /**
         * var ContactDto
         */
        $this->dto = $dto;

        $this->initialise_selectCount();

        $this->initialise_where();

        $this->initialise_orderBy();

        return $this->builder
            ->getQuery()->getSingleScalarResult();
    }

    public function findAllForDtoPaginator(DtoInterface $dto, $page = null, $limit = null)
    {
        /**
         * var ContactDto
         */
        $this->dto = $dto;

        $this->initialise_selectAll();

        $this->initialise_where();

        $this->initialise_orderBy();

        if (empty($page)) {
            $this->builder
                ->getQuery()
                ->getResult();
        } else {
            $this->builder
                ->setFirstResult(($page - 1) * $limit)
                ->setMaxResults($limit);
        }

        return new Paginator($this->builder);
    }

    public function findAllForDto(DtoInterface $dto)
    {
        /**
         * var ContactDto
         */
        $this->dto = $dto;

        $this->initialise_selectAll();

        $this->initialise_where();

        $this->initialise_orderBy();

       return $this->builder
            ->getQuery()
            ->getResult();

    }


    private function initialise_selectAll()
    {
        $this->builder = $this->createQueryBuilder(self::ALIAS)
            ->select(
                self::ALIAS,
                PictureRepository::ALIAS,
                ThematicRepository::ALIAS,
                UnderRubricRepository::ALIAS,
                UnderThematicRepository::ALIAS,
                BackpackRepository::ALIAS,
                CorbeilleRepository::ALIAS_RUBRIC_WRITERS,
                UserRepository::ALIAS_RUBRIC_WRITERS,
                CorbeilleRepository::ALIAS_RUBRIC_READERS,
                CorbeilleRepository::ALIAS_RUBRIC_READERS
            )
            ->leftJoin(self::ALIAS . '.picture', PictureRepository::ALIAS)
            ->leftJoin(self::ALIAS . '.thematic', ThematicRepository::ALIAS)
            ->leftJoin(self::ALIAS . '.underRubrics', UnderRubricRepository::ALIAS)
            ->leftJoin(UnderRubricRepository::ALIAS . '.underThematic', UnderThematicRepository::ALIAS)
            ->leftJoin(UnderRubricRepository::ALIAS . '.backpacks', BackpackRepository::ALIAS)
            ->leftJoin(self::ALIAS . '.writers', CorbeilleRepository::ALIAS_RUBRIC_WRITERS)
            ->leftJoin(CorbeilleRepository::ALIAS_RUBRIC_WRITERS . '.users', UserRepository::ALIAS_RUBRIC_WRITERS)
            ->leftJoin(self::ALIAS . '.readers', CorbeilleRepository::ALIAS_RUBRIC_READERS)
            ->leftJoin(CorbeilleRepository::ALIAS_RUBRIC_READERS . '.users', UserRepository::ALIAS_RUBRIC_READERS)
        ;


    }
    private function initialise_selectCount()
    {
        $this->builder = $this->createQueryBuilder(self::ALIAS)
            ->select('count(distinct ' . self::ALIAS . '.id)')
            ->leftJoin(self::ALIAS . '.thematic', ThematicRepository::ALIAS)
            ->leftJoin(self::ALIAS . '.underRubrics', UnderRubricRepository::ALIAS)
            ->leftJoin(self::ALIAS . '.writers', CorbeilleRepository::ALIAS_RUBRIC_WRITERS)
            ->leftJoin(CorbeilleRepository::ALIAS_RUBRIC_WRITERS . '.users', UserRepository::ALIAS_RUBRIC_WRITERS)
            ->leftJoin(self::ALIAS . '.readers', CorbeilleRepository::ALIAS_RUBRIC_READERS)
        ->leftJoin(CorbeilleRepository::ALIAS_RUBRIC_READERS . '.users', UserRepository::ALIAS_RUBRIC_READERS);
    }

    private function initialise_where()
    {
        $this->params = [];
        $dto = $this->dto;

        $this->builder
            ->where(self::ALIAS . '.id>0');

        $this->initialise_where_thematic();

        $this->initialise_where_underRubric();

        $this->initialise_where_enable();

        $this->initialise_where_user_can_show();


        $this->initialise_where_search();

        if (count($this->params) > 0) {
            $this->builder->setParameters($this->params);
        }

    }



    private function initialise_where_thematic()
    {
        if (!empty($this->dto->getThematic())) {
            $this->builder->andwhere(ThematicRepository::ALIAS . '.id = :thematicid');
            $this->addParams('thematicid', $this->dto->getThematic()->getId());
        }
    }



    private function initialise_where_enable()
    {
        if (!empty($this->dto->getEnable())) {
            if($this->dto->getEnable()== RubricDto::TRUE) {
                $this->builder->andwhere(self::ALIAS . '.enable= true');
            } elseif($this->dto->getEnable()== RubricDto::FALSE) {
                $this->builder->andwhere(self::ALIAS . '.enable= false');
            }
        }

        if (!empty($this->dto->getThematicEnable())) {
            if($this->dto->getThematicEnable()== RubricDto::TRUE) {
                $this->builder->andwhere(ThematicRepository::ALIAS . '.enable= true');
            } elseif($this->dto->getThematicEnable()== RubricDto::FALSE) {
                $this->builder->andwhere(ThematicRepository::ALIAS . '.enable= false');
            }
        }
    }

    private function initialise_where_underRubric()
    {
        if (!empty($this->dto->getUnderRubric())) {
            $this->builder->andwhere(UnderRubricRepository::ALIAS . '.id = :underrubricid');
            $this->addParams('underrubricid', $this->dto->getUnderRubric()->getId());
        }
    }

    private function initialise_where_search()
    {
        $dto = $this->dto;
        $builder = $this->builder;
        if (!empty($dto->getWordSearch())) {
            $builder
                ->andwhere(
                    self::ALIAS . '.content like :search' .
                    ' OR ' . self::ALIAS . '.name like :search' .
                    ' OR ' . ThematicRepository::ALIAS . '.name like :search' );

            $this->addParams('search', '%' . $dto->getWordSearch() . '%');
        }

    }
    private function initialise_where_user_can_show()
    {
        if (!empty($this->dto->getUser())) {
            $this->builder
                ->andwhere(
                    UserRepository::ALIAS_RUBRIC_WRITERS . '.id like :userId' .
                    ' OR ' . UserRepository::ALIAS_RUBRIC_READERS . '.id like :userId' .
                    ' OR ' . self::ALIAS . '.showAll = 1' );

            $this->addParams('userId', $this->dto->getUser()->getId());
        }
    }

    private function initialise_orderBy()
    {
        $this->builder
            ->orderBy(self::ALIAS . '.showOrder', 'ASC')
            ->addOrderBy(ThematicRepository::ALIAS . '.name', 'ASC')
            ->addOrderBy(self::ALIAS . '.name', 'ASC');
    }


}