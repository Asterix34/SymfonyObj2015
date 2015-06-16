<?php

namespace Stephane\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Stephane\BlogBundle\Entity\Categorie;

class LoadUserData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $cat = new Categorie();
        $cat->setNom("Catégorie 1");

        $manager->persist($cat);
        $manager->flush();
    }
}