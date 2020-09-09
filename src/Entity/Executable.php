<?php

namespace App\Entity;

use App\Repository\ExecutableRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExecutableRepository::class)
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
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

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

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
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
