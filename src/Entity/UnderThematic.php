<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UnderThematicRepository")
 */
class UnderThematic implements EntityInterface
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
     * @ORM\OneToMany(targetEntity="App\Entity\UnderRubric", mappedBy="underThematic")
     */
    private $underrubrics;

    public function __construct()
    {

        $this->showOrder=0;
        $this->underrubrics = new ArrayCollection();
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

    /**
     * @return Collection|UnderRubric[]
     */
    public function getUnderrubrics(): Collection
    {
        return $this->underrubrics;
    }

    public function addUnderrubric(UnderRubric $underrubric): self
    {
        if (!$this->underrubrics->contains($underrubric)) {
            $this->underrubrics[] = $underrubric;
            $underrubric->setUnderThematic($this);
        }

        return $this;
    }

    public function removeUnderrubric(UnderRubric $underrubric): self
    {
        if ($this->underrubrics->contains($underrubric)) {
            $this->underrubrics->removeElement($underrubric);
            // set the owning side to null (unless already changed)
            if ($underrubric->getUnderThematic() === $this) {
                $underrubric->setUnderThematic(null);
            }
        }

        return $this;
    }
}
