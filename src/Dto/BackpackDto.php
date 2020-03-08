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
}
