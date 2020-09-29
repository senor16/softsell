<?php

namespace App\DataFixtures;

use App\Entity\App;
use App\Entity\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {







        $manager->flush();
    }
}
