<?php

namespace App\DataFixtures;

use App\Entity\Job;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('en_US');
        $faker->addProvider(new \Faker\Provider\en_US\Company($faker));

        for ($i = 0; $i < 20; $i++) {
            $job = new Job();
            $job->setName($faker->catchPhrase);
            $job->setDescription($faker->bs);
            $job->setCompany($faker->company);

            $manager->persist($job);
        }

        $manager->flush();
    }
}
