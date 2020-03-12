<?php

namespace App\Dto;


class BackpackDto implements DtoInterface
{
    const FALSE='false';
    const TRUE='true';

    /**
     * @var ?string
     */
    private $wordSearch;
    /**
     * @var ?UnderRubric
     */
    private $underrubric;
    /**
     * @var ?Rubric
     */
    private $rubric;

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
    private $archiving;
    /**
     * @var ?String
     */
    private $new;
    /**
     * @var ?String
     */
    private $rubricEnable;

    /**
     * @var ?String
     */
    private $underrubricEnable;

    /**
     * @var ?String
     */
    private $underThematicEnable;

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
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @return BackpackDto
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUnderRubric()
    {
        return $this->underrubric;
    }

    /**
     * @param mixed $underrubric
     * @return BackpackDto
     */
    public function setUnderRubric($underrubric)
    {
        $this->underrubric = $underrubric;
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
     * @return BackpackDto
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
     * @return BackpackDto
     */
    public function setRubricEnable($rubricEnable)
    {
        $this->rubricEnable = $rubricEnable;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUnderRubricEnable()
    {
        return $this->underrubricEnable;
    }

    /**
     * @param mixed $underrubricEnable
     * @return BackpackDto
     */
    public function setUnderRubricEnable($underrubricEnable)
    {
        $this->underrubricEnable = $underrubricEnable;
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
     * @return BackpackDto
     */
    public function setUnderThematicEnable($underThematicEnable)
    {
        $this->underThematicEnable = $underThematicEnable;
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
     * @return BackpackDto
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
     * @return BackpackDto
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
     * @return BackpackDto
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
     * @return BackpackDto
     */
    public function setEnable($enable)
    {
        $this->enable = $enable;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getNew()
    {
        return $this->new;
    }

    /**
     * @param mixed $new
     * @return BackpackDto
     */
    public function setNew($new)
    {
        $this->new = $new;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getArchiving()
    {
        return $this->archiving;
    }

    /**
     * @param mixed $enable
     * @return BackpackDto
     */
    public function setArchiving($archiving)
    {
        $this->archiving = $archiving;
        return $this;
    }
}
