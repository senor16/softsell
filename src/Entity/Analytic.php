<?php

namespace App\Entity;

use App\Repository\AnalyticRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnalyticRepository::class)
 */
class Analytic
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
     * @ORM\Column(type="integer")
     */
    private $views;

    /**
     * @ORM\OneToOne(targetEntity=App::class, mappedBy="analytics", cascade={"persist", "remove"})
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

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function setViews(int $views): self
    {
        $this->views = $views;

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
        if ($app->getAnalytics() !== $this) {
            $app->setAnalytics($this);
        }

        return $this;
    }
}
