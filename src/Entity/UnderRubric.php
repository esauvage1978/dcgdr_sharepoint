<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UnderRubricRepository")
 */
class UnderRubric implements EntityInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enable;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="integer")
     */
    private $showOrder;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Rubric", inversedBy="underRubrics")
     * @ORM\JoinColumn(nullable=false)
     */
    private $rubric;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Picture", inversedBy="underRubrics")
     */
    private $picture;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UnderThematic", inversedBy="underrubrics")
     */
    private $underThematic;



    public function __construct()
    {
        $this->showOrder=0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEnable(): ?bool
    {
        return $this->enable;
    }

    public function setEnable(bool $enable): self
    {
        $this->enable = $enable;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getShowOrder(): ?int
    {
        return $this->showOrder;
    }

    public function setShowOrder(int $showOrder): self
    {
        $this->showOrder = $showOrder;

        return $this;
    }

    public function getRubric(): ?Rubric
    {
        return $this->rubric;
    }

    public function setRubric(?Rubric $rubric): self
    {
        $this->rubric = $rubric;

        return $this;
    }

    public function getPicture(): ?Picture
    {
        return $this->picture;
    }

    public function setPicture(?Picture $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getUnderThematic(): ?UnderThematic
    {
        return $this->underThematic;
    }

    public function setUnderThematic(?UnderThematic $underThematic): self
    {
        $this->underThematic = $underThematic;

        return $this;
    }


}
