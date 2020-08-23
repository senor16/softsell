<?php

namespace App\Entity;

use App\Repository\FileRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FileRepository::class)
 */
class File
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $windows;

    /**
     * @ORM\Column(type="integer")
     */
    private $linux;

    /**
     * @ORM\Column(type="integer")
     */
    private $mac;

    /**
     * @ORM\Column(type="integer")
     */
    private $android;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $windowsFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $linuxFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $macFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $androidFile;

    /**
     * @ORM\OneToOne(targetEntity=App::class, mappedBy="file", cascade={"persist", "remove"})
     */
    private $app;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWindows(): ?int
    {
        return $this->windows;
    }

    public function setWindows(int $windows): self
    {
        $this->windows = $windows;

        return $this;
    }

    public function getLinux(): ?int
    {
        return $this->linux;
    }

    public function setLinux(int $linux): self
    {
        $this->linux = $linux;

        return $this;
    }

    public function getMac(): ?int
    {
        return $this->mac;
    }

    public function setMac(int $mac): self
    {
        $this->mac = $mac;

        return $this;
    }

    public function getAndroid(): ?int
    {
        return $this->android;
    }

    public function setAndroid(int $android): self
    {
        $this->android = $android;

        return $this;
    }

    public function getWindowsFile(): ?string
    {
        return $this->windowsFile;
    }

    public function setWindowsFile(string $windowsFile): self
    {
        $this->windowsFile = $windowsFile;

        return $this;
    }

    public function getLinuxFile(): ?string
    {
        return $this->linuxFile;
    }

    public function setLinuxFile(string $linuxFile): self
    {
        $this->linuxFile = $linuxFile;

        return $this;
    }

    public function getMacFile(): ?string
    {
        return $this->macFile;
    }

    public function setMacFile(string $macFile): self
    {
        $this->macFile = $macFile;

        return $this;
    }

    public function getAndroidFile(): ?string
    {
        return $this->androidFile;
    }

    public function setAndroidFile(string $androidFile): self
    {
        $this->androidFile = $androidFile;

        return $this;
    }

    public function getApp(): ?App
    {
        return $this->app;
    }

    public function setApp(App $app): self
    {
        $this->app = $app;

        // set the owning side of the relation if necessary
        if ($app->getFile() !== $this) {
            $app->setFile($this);
        }

        return $this;
    }
}
