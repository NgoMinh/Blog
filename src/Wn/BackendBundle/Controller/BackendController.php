<?php

namespace Wn\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BackendController extends Controller
{
	public function indexAction()
	{
		return $this->render('WnBackendBundle:Backend:index.html.twig');
	}

	public function menuAction()
	{
		return $this->render('WnBackendBundle:Backend:menu.html.twig');
	}

	public function articleAction()
	{
		$entity_manager = $this->getDoctrine()->getManager();
		$articles       = $entity_manager->getRepository('WnBlogBundle:Article')->findAll();
		return $this->render('WnBackendBundle:Article:gestion.html.twig', array(
			'articles' => $articles
		));
	}

	public function commentaireAction()
	{
		$entity_manager = $this->getDoctrine()->getManager();
		$commentaires    = $entity_manager->getRepository('WnBlogBundle:Commentaire')->findAll();
		return $this->render('WnBackendBundle:Commentaire:gestion.html.twig', array(
			'commentaires' => $commentaires
		));
	}

	public function galerieAction()
	{
		$galerie = $this->getDoctrine()
		                ->getManager()
		                ->getRepository('WnGalerieBundle:Galerie')
		                ->findByNom('Galerie principale');
		
		return $this->render('WnBackendBundle:Galerie:gestion.html.twig', array(
			'galerie' => $galerie
		));
	}

	public function utilisateurAction()
	{
		$users = $this->getDoctrine()
		             ->getManager()
		             ->getRepository('WnUserBundle:User')
		             ->findAll();
		return $this->render('WnBackendBundle:Utilisateur:gestion.html.twig', array(
			'users' => $users
		));
	}

	public function categorieAction()
	{
		$categories = $this->getDoctrine()
					      ->getManager()
					      ->getRepository('WnBlogBundle:Categorie')
					      ->findAll();

		return $this->render('WnBackendBundle:Categorie:gestion.html.twig', array(
			'categories' => $categories
		));
	}

	public function model3DAction()
	{
		$models = $this->getDoctrine()
					   ->getManager()
					   ->getRepository('WnModel3DBundle:Model3D')
					   ->findAll();

		return $this->render('WnBackendBundle:Model3D:gestion.html.twig', array(
			'models' => $models
		));
	}

	public function loginAction()
	{
		return $this->render('WnBackendBundle:Backend:login.html.twig');
	}
}