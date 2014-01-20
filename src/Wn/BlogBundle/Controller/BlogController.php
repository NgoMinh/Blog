<?php

namespace Wn\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Wn\UserBundle\Entity\User;

class BlogController extends Controller
{
	public function indexAction()
	{
		$request = Request::createFromGlobals();
		$request->request->get('categorie','Blog Perso');
		$entity_manager = $this->getDoctrine()
		                       ->getManager();
		                       
		$categories = $entity_manager->getRepository('WnBlogBundle:Categorie')
									 ->findAll();

		$elements   = $entity_manager->getRepository('WnBlogBundle:Element')
									 ->findLastNStartAtX(10,0);

	 	return $this->render('WnBlogBundle:Blog:index.html.twig',array(
			'categories' => $categories,
			'elements'   => $elements,
			'categorie'  => $request
		));
	}

	public function elementAction()
	{
		$entity_manager = $this->getDoctrine()
		                       ->getManager();

		$request         = $this->get('request');
		$name_categorie  = $request->request->get('categorie');
		$startAt         = $request->request->get('startAt');
		$maxElement      = $request->request->get('maxElement');

		$elements = array();
		if($name_categorie == "all"){
			$elements = $entity_manager->getRepository('WnBlogBundle:Element')
		                               ->findLastNStartAtX($maxElement, $startAt);
		}elseif ($name_categorie == "Galerie") {
			$elements = $entity_manager->getRepository('WnGalerieBundle:ElementGalerie')
			                           ->findLastNStartAtX($maxElement, $startAt);
		}elseif ($name_categorie == "Model 3D") {
			$elements = $entity_manager->getRepository('WnModel3DBundle:Model3D')
			                           ->findLastNStartAtX($maxElement, $startAt);
		}else{
			$categorie = $entity_manager->getRepository('WnBlogBundle:Categorie')
			                            ->myfindByName($name_categorie);
			$elements  = $entity_manager->getRepository('WnBlogBundle:Article')
			                            ->findLastNStartAtXByCategorie($maxElement, $startAt, $categorie);
		}
		

		return $this->render('WnBlogBundle:Blog:elementAjouter.html.twig', array(
			"elements" => $elements
		));
	}

	public function menuAction()
	{
		$entity_manager = $this->getDoctrine()
							   ->getManager();

		$categories = $entity_manager->getRepository('WnBlogBundle:Categorie')
									 ->findAll();

		return $this->render('WnBlogBundle:Blog:menu.html.twig', array(
			'categories' => $categories
		));
	}

	public function testAction()
	{
		$entity_manager = $this->getDoctrine()
		                       ->getManager();

		$articles   = $entity_manager->getRepository('WnBlogBundle:Article')
		                             ->myFindAllOrderByDate();
		$galerie    = $entity_manager->getRepository('WnGalerieBundle:Galerie')
									 ->findByNom('Galerie principale');
		$categories = $entity_manager->getRepository('WnBlogBundle:Categorie')
									 ->findAll();
		$elements   = $entity_manager->getRepository('WnBlogBundle:Element')
									 ->myFindAllOrderByDate();

		return $this->render('WnBlogBundle:Blog:test.html.twig',array(
			'articles'   => $articles,
			'galerie'    => $galerie,
			'categories' => $categories,
			'elements'   => $elements,
		));
	}

	public function profilAction(User $utilisateur){

		$entity_manager = $this->getDoctrine()->getManager();

		if(in_array("ROLE_ADMIN", $utilisateur->getRoles())){
			$role = "Administrateur";
		}elseif (in_array("ROLE_AUTEUR", $utilisateur->getRoles()) && in_array("ROLE_MODERATEUR", $utilisateur->getRoles())){
			$role = "Auteur, Moderateur";
		}elseif (in_array("ROLE_AUTEUR", $utilisateur->getRoles())){
			$role = "Auteur";
		}elseif (in_array("ROLE_MODERATEUR", $utilisateur->getRoles())){
			$role = "Moderateur";
		}elseif (in_array("ROLE_USER", $utilisateur->getRoles())){
			$role = "Utilisateur";
		}

		$categorie_repository = $entity_manager->getRepository('WnBlogBundle:Categorie');
		$categorie_evenement  = $categorie_repository->myFindByName("Evenement");
		$categorie_chronique  = $categorie_repository->myFindByName("Chronique");
		$categorie_tutoriel   = $categorie_repository->myFindByName("Tutoriel");

		$article_repository = $entity_manager->getRepository('WnBlogBundle:Article');
		$evenements         = $article_repository->findByAuteurAndCategorie($utilisateur, $categorie_evenement);
		$tutoriels          = $article_repository->findByAuteurAndCategorie($utilisateur, $categorie_tutoriel);
		$chroniques         = $article_repository->findByAuteurAndCategorie($utilisateur, $categorie_chronique);

		$commentaires = $entity_manager->getRepository('WnBlogBundle:Commentaire')
									   ->findLastNByAuteur($utilisateur, 5);

		return $this->render('WnBlogBundle:User:Profil.html.twig', array(
			'utilisateur'  => $utilisateur,
			'role'         => $role,
			'commentaires' => $commentaires,
			'evenements'    => $evenements,
			'tutoriels'     => $tutoriels,
			'chroniques'    => $chroniques
		));
	}
}