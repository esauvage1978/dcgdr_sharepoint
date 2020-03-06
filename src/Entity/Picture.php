<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PictureRepository")
 * @ORM\EntityListeners({"App\Listener\PictureUploadListener"})
 */
class Picture implements EntityInterface
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
     * @ORM\Column(type="string", length=255)
     */
    private $fileName;

    private $file;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updateAt;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $fileExtension;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Rubric", mappedBy="picture")
     */
    private $rubrics;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UnderRubric", mappedBy="picture")
     */
    private $underRubrics;

    public function __construct()
    {
        $this->rubrics = new ArrayCollection();
        $this->underRubrics = new ArrayCollection();
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

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * @return string
     */
    public function getFullName(): ?string
    {
        return $this->fileName.'.'.$this->fileExtension;
    }

    /**
     * @return string
     */
    public function getHtmlImg(): ?string
    {
        return '<img src="' . $this->getHref() .'" class="img-flag"/>';
    }

    public function getHref(): string
    {
        return $this->getUploadDir() .  '/' . $this->getFileName() . '.' .  $this->getFileExtension() ;
    }



    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function getFileExtension(): ?string
    {
        return $this->fileExtension;
    }

    public function setFileExtension(string $fileExtension): self
    {
        $this->fileExtension = $fileExtension;

        return $this;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile(UploadedFile $picture): Picture
    {
        $this->file = $picture;

        return $this;
    }

    /**
     * @return string
     */
    public function getUploadDir(): string
    {
        return 'rubric' ;
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

    /**
     * @return Collection|Rubric[]
     */
    public function getRubrics(): Collection
    {
        return $this->rubrics;
    }

    public function addRubric(Rubric $rubric): self
    {
        if (!$this->rubrics->contains($rubric)) {
            $this->rubrics[] = $rubric;
            $rubric->setPicture($this);
        }

        return $this;
    }

    public function removeRubric(Rubric $rubric): self
    {
        if ($this->rubrics->contains($rubric)) {
            $this->rubrics->removeElement($rubric);
            // set the owning side to null (unless already changed)
            if ($rubric->getPicture() === $this) {
                $rubric->setPicture(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UnderRubric[]
     */
    public function getUnderRubrics(): Collection
    {
        return $this->underRubrics;
    }

    public function addUnderRubric(UnderRubric $underRubric): self
    {
        if (!$this->underRubrics->contains($underRubric)) {
            $this->underRubrics[] = $underRubric;
            $underRubric->setPicture($this);
        }

        return $this;
    }

    public function removeUnderRubric(UnderRubric $underRubric): self
    {
        if ($this->underRubrics->contains($underRubric)) {
            $this->underRubrics->removeElement($underRubric);
            // set the owning side to null (unless already changed)
            if ($underRubric->getPicture() === $this) {
                $underRubric->setPicture(null);
            }
        }

        return $this;
    }
}
