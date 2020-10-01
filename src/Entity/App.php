<?php

namespace App\Entity;

use App\Repository\AppRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Entity(repositoryClass=AppRepository::class)
 * @Vich\Uploadable
 * @UniqueEntity("slug")
 */
class App
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=3, max=255)
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=10,max=255)
     * @Assert\NotBlank()
     */
    private $short_description;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min=10)
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;


    /**
     * @Vich\UploadableField(mapping="application_images_upload", fileNameProperty="cover")
     * @var File|null
     *
     */
    private $coverFile;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string|null
     */
    private $cover;


    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Screenshot::class, mappedBy="app", cascade={"persist"})
     */
    private $screenshots;


    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="app", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=Executable::class, mappedBy="app",cascade={"persist"})
     */
    private $executables;


    /**
     * @ORM\Column(type="integer")
     */
    private $views;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=191, unique=true,)
     * @Assert\Length(min=1, max=191)
     * @Assert\Regex("#^[a-z0-9-]+$#")
     * @Assert\NotBlank()
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=Genre::class, inversedBy="apps")
     */
    private $genre;

    /**
     * @ORM\ManyToOne(targetEntity=Classification::class, inversedBy="apps")
     */
    private $classification;

    private $windows;
    private $mac;
    private $android;
    private $linux;

    private $windowsFile;
    private $macFile;
    private $androidFile;
    private $linuxFile;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isReleased;

    /**
     * @ORM\OneToMany(targetEntity=AppDownload::class, mappedBy="app")
     */
    private $downloads;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="publishedApp")
     */
    private $developer;

    public function __construct()
    {
        $this->screenshots = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->executables = new ArrayCollection();
        $this->downloads = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getWindowsFile()
    {
        return $this->windowsFile;
    }

    /**
     * @param mixed $windowsFile
     */
    public function setWindowsFile($windowsFile): void
    {
        $this->windowsFile = $windowsFile;
    }

    /**
     * @return mixed
     */
    public function getMacFile()
    {
        return $this->macFile;
    }

    /**
     * @param mixed $macFile
     */
    public function setMacFile($macFile): void
    {
        $this->macFile = $macFile;
    }

    /**
     * @return mixed
     */
    public function getAndroidFile()
    {
        return $this->androidFile;
    }

    /**
     * @param mixed $androidFile
     */
    public function setAndroidFile($androidFile): void
    {
        $this->androidFile = $androidFile;
    }

    /**
     * @return mixed
     */
    public function getLinuxFile()
    {
        return $this->linuxFile;
    }

    /**
     * @param mixed $linuxFile
     */
    public function setLinuxFile($linuxFile): void
    {
        $this->linuxFile = $linuxFile;
    }

    /**
     * @return mixed
     */
    public function getWindows()
    {
        return $this->windows;
    }

    /**
     * @param mixed $windows
     */
    public function setWindows($windows): void
    {
        $this->windows = $windows;
    }

    /**
     * @return mixed
     */
    public function getMac()
    {
        return $this->mac;
    }

    /**
     * @param mixed $mac
     */
    public function setMac($mac): void
    {
        $this->mac = $mac;
    }

    /**
     * @return mixed
     */
    public function getAndroid()
    {
        return $this->android;
    }

    /**
     * @param mixed $android
     */
    public function setAndroid($android): void
    {
        $this->android = $android;
    }

    /**
     * @return mixed
     */
    public function getLinux()
    {
        return $this->linux;
    }

    /**
     * @param mixed $linux
     */
    public function setLinux($linux): void
    {
        $this->linux = $linux;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function __toString()
    {
        return $this->title;
    }

    public function getShortDescription(): ?string
    {
        return $this->short_description;
    }

    public function setShortDescription(string $short_description): self
    {
        $this->short_description = $short_description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }


    /**
     * @return File|null
     */
    public function getCoverFile(): ?File
    {
        return $this->coverFile;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null
     */
    public function setCoverFile(?File $coverFile): void
    {
        $this->coverFile = $coverFile;

        if (null !== $coverFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }


    public function getCover()
    {
        return $this->cover;
    }


    public function setCover($cover): void
    {
        $this->cover = $cover;
    }


    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }


    public function setUpdatedAt($updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return Collection|Screenshot[]
     */
    public function getScreenshots(): Collection
    {
        return $this->screenshots;
    }

    public function addScreenshot(Screenshot $screenshot): self
    {
        if (!$this->screenshots->contains($screenshot)) {
            $this->screenshots[] = $screenshot;
            $screenshot->setApp($this);
        }

        return $this;
    }

    public function removeScreenshot(Screenshot $screenshot): self
    {
        if ($this->screenshots->contains($screenshot)) {
            $this->screenshots->removeElement($screenshot);
            // set the owning side to null (unless already changed)
            if ($screenshot->getApp() === $this) {
                $screenshot->setApp(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setApp($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getApp() === $this) {
                $comment->setApp(null);
            }
        }

        return $this;
    }

    public function addExecutable(Executable $executable): self
    {
        if (!$this->executables->contains($executable)) {
            $this->executables[] = $executable;
            $executable->setApp($this);
        }

        return $this;
    }

    public function removeExecutable(Executable $executable): self
    {
        if ($this->executables->contains($executable)) {
            $this->executables->removeElement($executable);
            // set the owning side to null (unless already changed)
            if ($executable->getApp() === $this) {
                $executable->setApp(null);
            }
        }

        return $this;
    }

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function setViews(int $views): self
    {
        $this->views = $views;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function computeSlug(SluggerInterface $slugger)
    {
        if (!$this->slug || '-' === $this->slug) {
            $this->slug = (string)$slugger->slug((string)$this)->lower();
        }
    }

    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(?Genre $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getClassification(): ?Classification
    {
        return $this->classification;
    }

    public function setClassification(?Classification $classification): self
    {
        $this->classification = $classification;

        return $this;
    }

    public function getIsReleased(): ?bool
    {
        return $this->isReleased;
    }

    public function setIsReleased(bool $isReleased): self
    {
        $this->isReleased = $isReleased;

        return $this;
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
            $download->setApp($this);
        }

        return $this;
    }

    public function removeDownload(AppDownload $download): self
    {
        if ($this->downloads->contains($download)) {
            $this->downloads->removeElement($download);
            // set the owning side to null (unless already changed)
            if ($download->getApp() === $this) {
                $download->setApp(null);
            }
        }
        return $this;
    }

    public function isDownloadedBy(User $user): bool
    {
        foreach ($this->downloads as $download) {

            if ($download->getUser() === $user) {
                return true;
            }
        }

        return false;
    }

    public function getTotalDownloads(): int
    {
        $d = 0;
        foreach ($this->getExecutables() as $exec) {
            $d += $exec->getDownloads();
        }

        return $d;
    }

    /**
     * @return Collection|Executable[]
     */
    public function getExecutables(): Collection
    {
        return $this->executables;
    }

    public function getDeveloper(): ?User
    {
        return $this->developer;
    }

    public function setDeveloper(?User $developer): self
    {
        $this->developer = $developer;

        return $this;
    }

}
