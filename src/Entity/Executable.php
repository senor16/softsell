<?php

namespace App\Entity;

use App\Repository\ExecutableRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ExecutableRepository::class)
 * @Vich\Uploadable
 */
class Executable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Vich\UploadableField(mapping="application_executables_upload", fileNameProperty="filename", size="size")
     * @var string|null
     */
    private $file;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $executablename;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $platform;

    /**
     * @ORM\Column(type="integer")
     */
    private $size;

    /**
     * @ORM\ManyToOne(targetEntity=App::class, inversedBy="executables")
     */
    private $app;

    /**
     * @ORM\Column(type="integer")
     */
    private $downloads;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExecutablename(): ?string
    {
        return $this->executablename;
    }

    public function setExecutablename(string $executablename): self
    {
        $this->executablename = $executablename;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null
     */
    public function setFile(?string $file): void
    {
        $this->file = $file;

        if(null !== $file){
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getPlatform(): ?string
    {
        return $this->platform;
    }

    public function setPlatform(string $platform): self
    {
        $this->platform = $platform;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function showSize():String{
        $i=0;
        $unit = [
          'O',
          'Ko',
          'Mo',
          'Go',
          'To',
        ];
        $siz = $this->size;
        while ($siz >1023){
            $siz/=1024;
            $i++;
        }
        return round($siz,2).' '. $unit[$i];
    }

    public function setSize(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getApp(): ?App
    {
        return $this->app;
    }

    public function setApp(?App $app): self
    {
        $this->app = $app;

        return $this;
    }

    public function getDownloads(): ?int
    {
        return $this->downloads;
    }

    public function setDownloads(int $downloads): self
    {
        $this->downloads = $downloads;

        return $this;
    }
}
