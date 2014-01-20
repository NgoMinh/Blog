<?php

namespace Wn\GalerieBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Wn\GalerieBundle\Entity\Galerie;

class Galeries implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$noms = array('Galerie principale');
		foreach($noms as $i => $nom){
			$liste_galerie[$i] = new Galerie();
			$liste_galerie[$i]->setNom($nom);

			$manager->persist($liste_galerie[$i]);
		}

		$manager->flush();
	}
}