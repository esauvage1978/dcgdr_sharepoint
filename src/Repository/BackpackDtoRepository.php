<?php


namespace App\Repository;


use App\Dto\BackpackDto;
use App\Dto\DtoInterface;
use App\Entity\Backpack;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

class BackpackDtoRepository extends ServiceEntityRepository implements DtoRepositoryInterface
{
    use TraitDtoRepository;

    const SELECT_ALL = 'select_all';
    const SELECT_PAGINATOR = 'select';

    const ALIAS = 'b';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Backpack::class);
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

    public function findAllForDtoPaginator(DtoInterface $dto, $page = null, $limit = null, $select = self::SELECT_ALL)
    {
        /**
         * var ContactDto
         */
        $this->dto = $dto;

        switch ($select) {
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

    public function findAllForDto(DtoInterface $dto, $select = self::SELECT_ALL)
    {
        /**
         * var ContactDto
         */
        $this->dto = $dto;

        switch ($select) {
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
                UnderRubricRepository::ALIAS,
                RubricRepository::ALIAS
            )
            ->leftJoin(self::ALIAS . '.underRubric', UnderRubricRepository::ALIAS)
            ->leftJoin(UnderRubricRepository::ALIAS . '.rubric', RubricRepository::ALIAS);


    }

    private function initialise_selectAll()
    {
        $this->builder = $this->createQueryBuilder(self::ALIAS)
            ->select(
                self::ALIAS,
                UnderRubricRepository::ALIAS,
                RubricRepository::ALIAS
            )
            ->leftJoin(self::ALIAS . '.underRubric', UnderRubricRepository::ALIAS)
            ->leftJoin(UnderRubricRepository::ALIAS . '.rubric', RubricRepository::ALIAS);


    }

    private function initialise_selectCount()
    {
        $this->builder = $this->createQueryBuilder(self::ALIAS)
            ->select('count(distinct ' . self::ALIAS . '.id)')
            ->leftJoin(self::ALIAS . '.underRubric', UnderRubricRepository::ALIAS)
            ->leftJoin(UnderRubricRepository::ALIAS . '.rubric', RubricRepository::ALIAS);
    }

    private function initialise_where()
    {
        $this->params = [];
        $dto = $this->dto;

        $this->builder
            ->where(self::ALIAS . '.id>0');

        $this->initialise_where_underRubric();

        $this->initialise_where_enable();

        $this->initialise_where_archiving();

        $this->initialise_where_search();

        if (count($this->params) > 0) {
            $this->builder->setParameters($this->params);
        }

    }


    private function initialise_where_archiving()
    {
        if (!empty($this->dto->getArchiving())) {
            if ($this->dto->getArchiving() == BackpackDto::TRUE) {
                $this->builder->andwhere(self::ALIAS . '.archiving= true');
            } elseif ($this->dto->getArchiving() == BackpackDto::FALSE) {
                $this->builder->andwhere(self::ALIAS . '.archiving= false');
            }
        }


    }

    private function initialise_where_enable()
    {
        if (!empty($this->dto->getEnable())) {
            if ($this->dto->getEnable() == BackpackDto::TRUE) {
                $this->builder->andwhere(self::ALIAS . '.enable= true');
            } elseif ($this->dto->getEnable() == BackpackDto::FALSE) {
                $this->builder->andwhere(self::ALIAS . '.enable= false');
            }
        }
        if (!empty($this->dto->getThematicEnable())) {
            if ($this->dto->getThematicEnable() == BackpackDto::TRUE) {
                $this->builder->andwhere(ThematicRepository::ALIAS . '.enable= true');
            } elseif ($this->dto->getThematicEnable() == BackpackDto::FALSE) {
                $this->builder->andwhere(ThematicRepository::ALIAS . '.enable= false');
            }
        }


        if (!empty($this->dto->getUnderThematicEnable())) {
            if ($this->dto->getUnderThematicEnable() == BackpackDto::TRUE) {
                $this->builder->andwhere(UnderThematicRepository::ALIAS . '.enable= true');
            } elseif ($this->dto->getUnderThematicEnable() == BackpackDto::FALSE) {
                $this->builder->andwhere(UnderThematicRepository::ALIAS . '.enable= false');
            }
        }

        if (!empty($this->dto->getRubricEnable())) {
            if ($this->dto->getRubricEnable() == BackpackDto::TRUE) {
                $this->builder->andwhere(RubricRepository::ALIAS . '.enable= true');
            } elseif ($this->dto->getRubricEnable() == BackpackDto::FALSE) {
                $this->builder->andwhere(RubricRepository::ALIAS . '.enable= false');
            }
        }

        if (!empty($this->dto->getUnderRubricEnable())) {
            if ($this->dto->getUnderRubricEnable() == BackpackDto::TRUE) {
                $this->builder->andwhere(UnderRubricRepository::ALIAS . '.enable= true');
            } elseif ($this->dto->getUnderRubricEnable() == BackpackDto::FALSE) {
                $this->builder->andwhere(UnderRubricRepository::ALIAS . '.enable= false');
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
                    ' OR ' . self::ALIAS . '.dir1 like :search' .
                    ' OR ' . self::ALIAS . '.dir2 like :search' .
                    ' OR ' . self::ALIAS . '.dir3 like :search' .
                    ' OR ' . self::ALIAS . '.dir4 like :search' .
                    ' OR ' . self::ALIAS . '.dir5 like :search' .
                    ' OR ' . self::ALIAS . '.name like :search');

            $this->addParams('search', '%' . $dto->getWordSearch() . '%');
        }

    }

    private function initialise_orderBy()
    {
        $this->builder
            ->addOrderBy(RubricRepository::ALIAS.'.name','ASC')
            ->addOrderBy(UnderRubricRepository::ALIAS.'.name','ASC')
            ->addOrderBy(self::ALIAS . '.dir1', 'ASC')
            ->addOrderBy(self::ALIAS . '.dir2', 'ASC')
            ->addOrderBy(self::ALIAS . '.dir3', 'ASC')
            ->addOrderBy(self::ALIAS . '.dir4', 'ASC')
            ->addOrderBy(self::ALIAS . '.dir5', 'ASC')
            ->addOrderBy(self::ALIAS . '.name', 'ASC');
    }


}