<?php

namespace App\Entity;

use App\Repository\GenreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GenreRepository::class)
 */
class Genre
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
    private $fr;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $en;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_game;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFr(): ?string
    {
        return $this->fr;
    }

    public function setFr(string $fr): self
    {
        $this->fr = $fr;

        return $this;
    }

    public function getEn(): ?string
    {
        return $this->en;
    }

    public function setEn(string $en): self
    {
        $this->en = $en;

        return $this;
    }

    public function getIsGame(): ?bool
    {
        return $this->is_game;
    }

    public function setIsGame(bool $is_game): self
    {
        $this->is_game = $is_game;

        return $this;
    }
}
