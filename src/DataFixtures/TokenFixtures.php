<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\ApiToken;
use App\Entity\User;

class TokenFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $apiToken1 = new ApiToken($user);
        // $apiToken2 = new ApiToken($user);
        // $manager->persist($apiToken1);
        // $manager->persist($apiToken2);

        $manager->flush();
    }
}
