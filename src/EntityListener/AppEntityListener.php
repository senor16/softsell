<?php


namespace App\EntityListener;


use App\Entity\App;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;

class AppEntityListener
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function prePersist(App $app, LifecycleEventArgs $args){
        $app->computeSlug($this->slugger);
    }

    public function preUpdate(App $app, LifecycleEventArgs $args){
        $app->computeSlug($this->slugger);
    }

}