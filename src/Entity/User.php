<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
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
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="boolean")
     */
    private $gender;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDevelopper;

    /**
     * @ORM\OneToMany(targetEntity=App::class, mappedBy="user", orphanRemoval=true)
     */
    private $publishedApp;

    public function __construct()
    {
        $this->publishedApp = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getGender(): ?bool
    {
        return $this->gender;
    }

    public function setGender(bool $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getIsDevelopper(): ?bool
    {
        return $this->isDevelopper;
    }

    public function setIsDevelopper(bool $isDevelopper): self
    {
        $this->isDevelopper = $isDevelopper;

        return $this;
    }

    /**
     * @return Collection|App[]
     */
    public function getPublishedApp(): Collection
    {
        return $this->publishedApp;
    }

    public function addPublishedApp(App $publishedApp): self
    {
        if (!$this->publishedApp->contains($publishedApp)) {
            $this->publishedApp[] = $publishedApp;
            $publishedApp->setUser($this);
        }

        return $this;
    }

    public function removePublishedApp(App $publishedApp): self
    {
        if ($this->publishedApp->contains($publishedApp)) {
            $this->publishedApp->removeElement($publishedApp);
            // set the owning side to null (unless already changed)
            if ($publishedApp->getUser() === $this) {
                $publishedApp->setUser(null);
            }
        }

        return $this;
    }
}
