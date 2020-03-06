<?php


namespace App\Repository;


use App\Dto\DtoInterface;
use App\Dto\UnderRubricDto;
use App\Entity\UnderRubric;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

class UnderRubricDtoRepository extends ServiceEntityRepository implements DtoRepositoryInterface
{
    use TraitDtoRepository;

    const SELECT_ALL='select_all';
    const SELECT_PAGINATOR='select';

    const ALIAS = 'ur';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UnderRubric::class);
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

    public function findAllForDtoPaginator(DtoInterface $dto, $page = null, $limit = null,$select=self::SELECT_ALL)
    {
        /**
         * var ContactDto
         */
        $this->dto = $dto;

        switch($select) {
            case self::SELECT_PAGINATOR:
                $this->initialise_select();
                break;
            default:
                $this->initialise_selectAll();
                break;

        }

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

    public function findAllForDto(DtoInterface $dto,$select=self::SELECT_ALL)
    {
        /**
         * var ContactDto
         */
        $this->dto = $dto;

        switch($select) {
            case self::SELECT_PAGINATOR:
                $this->initialise_select();
                break;
            default:
                $this->initialise_selectAll();
                break;

        }

        $this->initialise_where();

        $this->initialise_orderBy();

       return $this->builder
            ->getQuery()
            ->getResult();

    }

    private function initialise_select()
    {
        $this->builder = $this->createQueryBuilder(self::ALIAS)
            ->select(
                self::ALIAS,
                UnderThematicRepository::ALIAS,
                RubricRepository::ALIAS,
                ThematicRepository::ALIAS
            )
            ->leftJoin(self::ALIAS . '.underThematic', UnderThematicRepository::ALIAS)
            ->leftJoin(self::ALIAS . '.rubric', RubricRepository::ALIAS)
            ->leftJoin(RubricRepository::ALIAS . '.thematic', ThematicRepository::ALIAS)
            ;

    }
    private function initialise_selectAll()
    {
        $this->builder = $this->createQueryBuilder(self::ALIAS)
            ->select(
                self::ALIAS,
                UnderThematicRepository::ALIAS,
                RubricRepository::ALIAS,
                ThematicRepository::ALIAS
            )
            ->leftJoin(self::ALIAS . '.underThematic', UnderThematicRepository::ALIAS)
            ->leftJoin(self::ALIAS . '.rubric', RubricRepository::ALIAS)
            ->leftJoin(RubricRepository::ALIAS . '.thematic', ThematicRepository::ALIAS)
        ;


    }
    private function initialise_selectCount()
    {
        $this->builder = $this->createQueryBuilder(self::ALIAS)
            ->select('count(distinct ' . self::ALIAS . '.id)')
            ->leftJoin(self::ALIAS . '.underThematic', UnderThematicRepository::ALIAS)
            ->leftJoin(self::ALIAS . '.rubric', RubricRepository::ALIAS)
            ->leftJoin(RubricRepository::ALIAS . '.thematic', ThematicRepository::ALIAS);
    }

    private function initialise_where()
    {
        $this->params = [];
        $dto = $this->dto;

        $this->builder
            ->where(self::ALIAS . '.id>0');

        $this->initialise_where_underThematic();

        $this->initialise_where_rubric();

        $this->initialise_where_enable();

        $this->initialise_where_search();

        if (count($this->params) > 0) {
            $this->builder->setParameters($this->params);
        }

    }

    private function initialise_where_underThematic()
    {
        if (!empty($this->dto->getUnderThematic())) {
            $this->builder->andwhere(UnderThematicRepository::ALIAS . '.id = :underthematicid');
            $this->addParams('underthematicid', $this->dto->getUnderThematic()->getId());
        }
    }

    private function initialise_where_rubric()
    {
        if (!empty($this->dto->getRubric())) {
            $this->builder->andwhere(RubricRepository::ALIAS . '.id = :rubricid');
            $this->addParams('rubricid', $this->dto->getRubric()->getId());
        }
    }

    private function initialise_where_enable()
    {
        if (!empty($this->dto->getEnable())) {
            if($this->dto->getEnable()== UnderRubricDto::TRUE) {
                $this->builder->andwhere(self::ALIAS . '.enable= true');
            } elseif($this->dto->getEnable()== UnderRubricDto::FALSE) {
                $this->builder->andwhere(self::ALIAS . '.enable= false');
            }
        }

        if (!empty($this->dto->getThematicEnable())) {
        if($this->dto->getThematicEnable()== UnderRubricDto::TRUE) {
            $this->builder->andwhere(ThematicRepository::ALIAS . '.enable= true');
        } elseif($this->dto->getThematicEnable()== UnderRubricDto::FALSE) {
            $this->builder->andwhere(ThematicRepository::ALIAS . '.enable= false');
        }
    }

        if (!empty($this->dto->getUnderThematicEnable())) {
            if($this->dto->getUnderThematicEnable()== UnderRubricDto::TRUE) {
                $this->builder->andwhere(UnderThematicRepository::ALIAS . '.enable= true');
            } elseif($this->dto->getUnderThematicEnable()== UnderRubricDto::FALSE) {
                $this->builder->andwhere(UnderThematicRepository::ALIAS . '.enable= false');
            }
        }

        if (!empty($this->dto->getRubricEnable())) {
            if($this->dto->getRubricEnable()== UnderRubricDto::TRUE) {
                $this->builder->andwhere(RubricRepository::ALIAS . '.enable= true');
            } elseif($this->dto->getRubricEnable()== UnderRubricDto::FALSE) {
                $this->builder->andwhere(RubricRepository::ALIAS . '.enable= false');
            }
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
                    ' OR ' . UnderThematicRepository::ALIAS . '.name like :search' );

            $this->addParams('search', '%' . $dto->getWordSearch() . '%');
        }

    }

    private function initialise_orderBy()
    {
        $this->builder
            ->orderBy(self::ALIAS . '.showOrder', 'ASC')
            ->addOrderBy(UnderThematicRepository::ALIAS . '.name', 'ASC')
            ->addOrderBy(self::ALIAS . '.name', 'ASC');
    }


}