<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity("email",message="L'email que vous avez indiqué est déja utilisé")
 * @UniqueEntity("username",message="Ce nom d'utilisateur est déja utilisé")
 */
class User implements UserInterface
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
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\ManyToOne(targetEntity=Gender::class, inversedBy="users")
     */
    private $gender;



    private $avatarFile;




    /**
     * @ORM\OneToMany(targetEntity=AppDownload::class, mappedBy="user")
     */
    private $downloads;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $role;

    /**
     * @ORM\OneToMany(targetEntity=App::class, mappedBy="developer")
     */
    private $publishedApp;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $displayName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url()
     */
    private $website;



    public function __construct()
    {
        $this->downloads = new ArrayCollection();
        $this->publishedApp = new ArrayCollection();
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
     * @return mixed
     */
    public function getConfirmPassword()
    {
        return $this->confirmPassword;
    }

    /**
     * @param mixed $confirmPassword
     */
    public function setConfirmPassword($confirmPassword): void
    {
        $this->confirmPassword = $confirmPassword;
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

    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    public function setGender(?Gender $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

  
    public function getAvatarFile()
    {
        return $this->avatarFile;
    }


    public function setAvatarFile($avatarFile): void
    {
        $this->avatarFile = $avatarFile;
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
        if ($this->role == 'ROLE_DEVELOPER') {
            return ['ROLE_DEVELOPER'];
        }

        return ['ROLE_USER'];
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
            $download->setUser($this);
        }

        return $this;
    }

    public function removeDownload(AppDownload $download): self
    {
        if ($this->downloads->contains($download)) {
            $this->downloads->removeElement($download);
            // set the owning side to null (unless already changed)
            if ($download->getUser() === $this) {
                $download->setUser(null);
            }
        }

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = strtoupper($role);

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
            $publishedApp->setDeveloper($this);
        }

        return $this;
    }

    public function removePublishedApp(App $publishedApp): self
    {
        if ($this->publishedApp->contains($publishedApp)) {
            $this->publishedApp->removeElement($publishedApp);
            // set the owning side to null (unless already changed)
            if ($publishedApp->getDeveloper() === $this) {
                $publishedApp->setDeveloper(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->username;
    }

    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    public function setDisplayName(?string $displayName): self
    {
        $this->displayName = $displayName;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

}
