<?php

namespace Wn\GalleryBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Wn\GalleryBundle\Entity\Gallery;

class Gallerys implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$names = array('Main Gallery');
		foreach($names as $i => $name){
			$gallery_list[$i] = new Gallery();
			$gallery_list[$i]->setName($name);

			$manager->persist($gallery_list[$i]);
		}

		$manager->flush();
	}
}