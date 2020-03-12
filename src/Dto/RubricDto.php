<?php

namespace App\Dto;

use App\Entity\Rubric;
use App\Entity\Thematic;

class RubricDto implements DtoInterface
{
    const FALSE='false';
    const TRUE='true';

    /**
     * @var ?string
     */
    private $wordSearch;




    /**
     * @var ?Thematic
     */
    private $thematic;

    /**
     * @var ?String
     */
    private $page;

    /**
     * @var ?String
     */
    private $enable;

    /**
     * @var ?String
     */
    private $thematicEnable;

    /**
     * @var ?User
     */
    private $user;

    /**
     * @return mixed
     */
    public function getUnderThematicEnable()
    {
        return $this->underThematicEnable;
    }

    /**
     * @param mixed $underThematicEnable
     * @return RubricDto
     */
    public function setUnderThematicEnable($underThematicEnable)
    {
        $this->underThematicEnable = $underThematicEnable;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUnderRubricEnable()
    {
        return $this->underRubricEnable;
    }

    /**
     * @param mixed $underRubricEnable
     * @return RubricDto
     */
    public function setUnderRubricEnable($underRubricEnable)
    {
        $this->underRubricEnable = $underRubricEnable;
        return $this;
    }

    /**
     * @var ?String
     */
    private $underThematicEnable;

    /**
     * @var ?String
     */
    private $underRubricEnable;

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @return RubricDto
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getThematicEnable()
    {
        return $this->thematicEnable;
    }

    /**
     * @param mixed $thematicEnable
     * @return RubricDto
     */
    public function setThematicEnable($thematicEnable)
    {
        $this->thematicEnable = $thematicEnable;
        return $this;
    }

    /**
     * @var ?UnderRubric
     */
    private $underRubric;

    /**
     * @return mixed
     */
    public function getUnderRubric()
    {
        return $this->underRubric;
    }

    /**
     * @param mixed $underRubric
     * @return RubricDto
     */
    public function setUnderRubric($underRubric)
    {
        $this->underRubric = $underRubric;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getWordSearch()
    {
        return $this->wordSearch;
    }

    /**
     * @param mixed $wordSearch
     * @return RubricDto
     */
    public function setWordSearch($wordSearch)
    {
        $this->wordSearch = $wordSearch;
        return $this;
    }

    /**
     * @return null | Thematic
     */
    public function getThematic():?Thematic
    {
        return $this->thematic;
    }

    /**
     * @param mixed $civilite
     * @return RubricDto
     */
    public function setThematic($thematic)
    {
        $this->thematic = $thematic;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param mixed $page
     * @return RubricDto
     */
    public function setPage($page)
    {
        $this->page = $page;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getEnable()
    {
        return $this->enable;
    }

    /**
     * @param mixed $enable
     * @return RubricDto
     */
    public function setEnable($enable)
    {
        $this->enable = $enable;
        return $this;
    }
}
