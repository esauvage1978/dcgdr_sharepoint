<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CorbeilleRepository")
 */
class Corbeille implements EntityInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40)
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
     * @ORM\Column(type="boolean")
     */
    private $showRead;

    /**
     * @ORM\Column(type="boolean")
     */
    private $showWrite;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Organisme", inversedBy="corbeilles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $organisme;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="corbeilles",fetch="LAZY")
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $users;



    public function __construct()
    {
        $this->users = new ArrayCollection();
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



    public function getShowRead(): ?bool
    {
        return $this->showRead;
    }

    public function setShowRead(bool $showRead): self
    {
        $this->showRead = $showRead;

        return $this;
    }

    public function getShowWrite(): ?bool
    {
        return $this->showWrite;
    }

    public function setShowWrite(bool $showWrite): self
    {
        $this->showWrite = $showWrite;

        return $this;
    }


    public function getOrganisme(): ?Organisme
    {
        return $this->organisme;
    }

    public function setOrganisme(?Organisme $organisme): self
    {
        $this->organisme = $organisme;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
        }

        return $this;
    }

    public function getFullName(): ?string
    {
        return (null !== $this->organisme) ?
            $this->getOrganisme()->getRef().' - '.$this->getName() :
            $this->getName();
    }


}
