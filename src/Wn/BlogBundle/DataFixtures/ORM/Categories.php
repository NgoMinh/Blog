<?php

namespace Wn\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Wn\BlogBundle\Entity\Categorie;

class Categories implements FixtureInterface
{
	public function load(ObjectManager $manager){
		$nom = array('tutoriel','événement','loisir','astuce','découverte');
		foreach($nom as $i => $nom){
			$liste_categorie[$i] = new Categorie();
			$liste_categorie[$i]->setNom($nom);

			$manager->persist($liste_categorie[$i]);
		}
		$manager->flush();
	}
}