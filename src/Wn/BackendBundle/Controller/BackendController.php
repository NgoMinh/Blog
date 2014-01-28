<?php

namespace Wn\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BackendController extends Controller
{
	public function indexAction()
	{
		return $this->render('WnBackendBundle:Backend:index.html.twig');
	}

	public function navAction()
	{
		return $this->render('WnBackendBundle:Backend:nav.html.twig');
	}

	public function articleAction()
	{
		$articles = $this->getDoctrine()
		                 ->getManager()
		                 ->getRepository('WnBlogBundle:Article')
		                 ->findAll();

		return $this->render('WnBackendBundle:Article:gestion.html.twig', array(
			'articles' => $articles
		));
	}

	public function commentAction()
	{
		$comments = $this->getDoctrine()
						 ->getManager()
					     ->getRepository('WnBlogBundle:Comment')
					     ->findAll();

		return $this->render('WnBackendBundle:Comment:gestion.html.twig', array(
			'comments' => $comments
		));
	}

	public function galleryAction()
	{
		$gallery = $this->getDoctrine()
		                ->getManager()
		                ->getRepository('WnGalleryBundle:Gallery')
		                ->findByName('Main Gallery');
		
		return $this->render('WnBackendBundle:Gallery:gestion.html.twig', array(
			'gallery' => $gallery
		));
	}

	public function userAction()
	{
		$users = $this->getDoctrine()
		              ->getManager()
		              ->getRepository('WnUserBundle:User')
		              ->findAll();
		return $this->render('WnBackendBundle:User:gestion.html.twig', array(
			'users' => $users
		));
	}

	public function categoryAction()
	{
		$categories = $this->getDoctrine()
					       ->getManager()
					       ->getRepository('WnBlogBundle:category')
					       ->findAll();

		return $this->render('WnBackendBundle:Category:gestion.html.twig', array(
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