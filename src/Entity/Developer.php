<?php

namespace App\Entity;

use App\Repository\DeveloperRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=DeveloperRepository::class)
 * @UniqueEntity("email",message="L'email que vous avez indiqué est déja utilisé")
 * @UniqueEntity("username",message="Ce nom d'utilisateur est déja utilisé")
 */
class Developer implements UserInterface
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
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8", minMessage="Votre mot de passe doit faire au minimum 8 caractères")
     */
    private $password;
    /**
     * @Assert\EqualTo(propertyPath="password", message="Vos mots de passes ne correspondent pas")
     */
    private $confirmPassword;


    /**
     * @ORM\OneToMany(targetEntity=App::class, mappedBy="developer", orphanRemoval=true)
     */
    private $uploads;



    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $avatar;

    /**
     * @ORM\ManyToOne(targetEntity=Gender::class, inversedBy="developers")
     */
    private $gender;

    /**
     * @ORM\OneToMany(targetEntity=AppDownload::class, mappedBy="developer")
     */
    private $downloads;

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
     * @return string|null
     */
    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }

    /**
     * @param string|null $confirmPassword
     */
    public function setConfirmPassword(?string $confirmPassword): void
    {
        $this->confirmPassword = $confirmPassword;
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





    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function __toString()
    {
        return (string)$this->username;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    public function setGender(?Gender $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return string[] The user roles
     */
    public function getRoles()
    {
        return ['ROLE_DEVELOPER'];
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }


    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return Collection|AppDownload[]
     */
    public function getDownloads(): Collection
    {
        return $this->downloads;
    }

    public function addDownload(AppDownload $download): self
    {
        if (!$this->downloads->contains($download)) {
            $this->downloads[] = $download;
            $download->setDeveloper($this);
        }

        return $this;
    }

    public function removeDownload(AppDownload $download): self
    {
        if ($this->downloads->contains($download)) {
            $this->downloads->removeElement($download);
            // set the owning side to null (unless already changed)
            if ($download->getDeveloper() === $this) {
                $download->setDeveloper(null);
            }
        }

        return $this;
    }
}
