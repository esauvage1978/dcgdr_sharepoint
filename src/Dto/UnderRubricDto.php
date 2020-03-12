<?php

namespace App\Dto;

use App\Entity\Rubric;

class UnderRubricDto implements DtoInterface
{
    const FALSE='false';
    const TRUE='true';

    /**
     * @var ?string
     */
    private $wordSearch;
    /**
     * @var ?Rubric
     */
    private $rubric;

    /**
     * @var ?User
     */
    private $user;

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @return UnderRubricDto
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @var ?UnderThematic
     */
    private $underThematic;

    /**
     * @return mixed
     */
    public function getUnderThematic()
    {
        return $this->underThematic;
    }

    /**
     * @param mixed $underThematic
     * @return UnderRubricDto
     */
    public function setUnderThematic($underThematic)
    {
        $this->underThematic = $underThematic;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getRubric()
    {
        return $this->rubric;
    }

    /**
     * @param mixed $rubric
     * @return UnderRubricDto
     */
    public function setRubric($rubric)
    {
        $this->rubric = $rubric;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRubricEnable()
    {
        return $this->rubricEnable;
    }

    /**
     * @param mixed $rubricEnable
     * @return UnderRubricDto
     */
    public function setRubricEnable($rubricEnable)
    {
        $this->rubricEnable = $rubricEnable;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUnderThematicEnable()
    {
        return $this->underThematicEnable;
    }

    /**
     * @param mixed $underThematicEnable
     * @return UnderRubricDto
     */
    public function setUnderThematicEnable($underThematicEnable)
    {
        $this->underThematicEnable = $underThematicEnable;
        return $this;
    }

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
    private $rubricEnable;

    /**
     * @var ?String
     */
    private $underThematicEnable;

    /**
     * @var ?String
     */
    private $thematicEnable;

    /**
     * @return mixed
     */
    public function getThematicEnable()
    {
        return $this->thematicEnable;
    }

    /**
     * @param mixed $thematicEnable
     * @return UnderRubricDto
     */
    public function setThematicEnable($thematicEnable)
    {
        $this->thematicEnable = $thematicEnable;
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
     * @return UnderRubricDto
     */
    public function setWordSearch($wordSearch)
    {
        $this->wordSearch = $wordSearch;
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
     * @return UnderRubricDto
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
     * @return UnderRubricDto
     */
    public function setEnable($enable)
    {
        $this->enable = $enable;
        return $this;
    }
}
