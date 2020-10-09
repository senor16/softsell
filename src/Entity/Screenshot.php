<?php

namespace App\Entity;

use App\Repository\ScreenshotRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ScreenshotRepository::class)
 */
class Screenshot
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;



    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;



    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @ORM\ManyToOne(targetEntity=App::class, inversedBy="screenshots")
     */
    private $app;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mini;

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



    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt): void
    {
        $this->updatedAt = $updatedAt;
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

    public function getMini(): ?string
    {
        return $this->mini;
    }

    public function setMini(string $mini): self
    {
        $this->mini = $mini;

        return $this;
    }
}
