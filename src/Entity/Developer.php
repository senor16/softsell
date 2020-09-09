<?php

namespace App\Entity;

use App\Repository\DeveloperRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DeveloperRepository::class)
 */
class Developer
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
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $last_name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=App::class, mappedBy="developer", orphanRemoval=true)
     */
    private $uploads;

    /**
     * @ORM\ManyToMany(targetEntity=App::class)
     */
    private $downloads;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __construct()
    {
        $this->uploads = new ArrayCollection();
        $this->downloads = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection|App[]
     */
    public function getUploads(): Collection
    {
        return $this->uploads;
    }

    public function addUpload(App $upload): self
    {
        if (!$this->uploads->contains($upload)) {
            $this->uploads[] = $upload;
            $upload->setDeveloper($this);
        }

        return $this;
    }

    public function removeUpload(App $upload): self
    {
        if ($this->uploads->contains($upload)) {
            $this->uploads->removeElement($upload);
            // set the owning side to null (unless already changed)
            if ($upload->getDeveloper() === $this) {
                $upload->setDeveloper(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|App[]
     */
    public function getDownloads(): Collection
    {
        return $this->downloads;
    }

    public function addDownload(App $download): self
    {
        if (!$this->downloads->contains($download)) {
            $this->downloads[] = $download;
        }

        return $this;
    }

    public function removeDownload(App $download): self
    {
        if ($this->downloads->contains($download)) {
            $this->downloads->removeElement($download);
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
