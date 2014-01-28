<?php

namespace Wn\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Wn\BlogBundle\Entity\Category;

class Categories implements FixtureInterface
{
	public function load(ObjectManager $manager){
		$name = array('Tutoriel','Evénement','Chronic');
		foreach($name as $i => $name){
			$liste_category[$i] = new Category();
			$liste_category[$i]->setName($name);

			$manager->persist($liste_category[$i]);
		}
		$manager->flush();
	}
}