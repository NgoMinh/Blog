<?php

namespace Wn\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Wn\UserBundle\Entity\User;
use Wn\BlogBundle\Entity\Element;

class BlogController extends Controller
{
	/**
	 * Render the homepage
	 */
	public function homepageAction()
	{
		
		$em         = $this->getDoctrine()->getManager();
		$request    = Request::createFromGlobals();
		$request->request->get('category','Blog Perso');                       
		$categories = $em->getRepository('WnBlogBundle:Category')
			             ->findAll();

		$elements   = $em->getRepository('WnBlogBundle:Element')
		                 ->findLastNStartAtX(1,0);
             
	 	return $this->render('WnBlogBundle:Blog:homepage.html.twig',array(
			'categories'  => $categories,
			'elements'    => $elements,
			'category'    => $request
		));
	}

	public function updateHomepageElementAction()
	{
		$em = $this->getDoctrine()->getManager();

		$request          = $this->get('request');
		$category_name    = $request->request->get('category');
		$start_at         = $request->request->get('start_at');
		$max_element      = $request->request->get('max_element');

		$elements = array();
		if($category_name == "all"){
			$elements = $em->getRepository('WnBlogBundle:Element')
		                   ->findLastNStartAtX($max_element, $start_at);
		}elseif ($category_name == "Gallery") {
			$elements = $em->getRepository('WnGalerieBundle:ElementGallery')
			               ->findLastNStartAtX($max_element, $start_at);
		}elseif ($category_name == "Model 3D") {
			$elements = $em->getRepository('WnModel3DBundle:Model3D')
			               ->findLastNStartAtX($max_element, $start_at);
		}else{
			$category = $em->getRepository('WnBlogBundle:Category')
			                ->findByName($category_name);
			$elements = $em->getRepository('WnBlogBundle:Article')
			                ->findLastNStartAtXByCategory($max_element, $start_at, $category);
		}
		

		return $this->render('WnBlogBundle:Blog:viewOnHomepage.html.twig', array(
			"elements" => $elements
		));
	}

	public function navAction()
	{
		$categories = $this->getDoctrine()
					       ->getManager()
						   ->getRepository('WnBlogBundle:Category')
						   ->findAll();
		return $this->render('WnBlogBundle:Blog:nav.html.twig', array(
			'categories' => $categories
		));
	}

	public function navOnViewAction()
	{
		$categories = $this->getDoctrine()
						   ->getManager()
						   ->getRepository('WnBlogBundle:Category')
						   ->findAll();
		return $this->render('WnBlogBundle:Blog:navOnView.html.twig', array(
			'categories' => $categories
		));
	}

	public function profileAction(User $user)
	{
		$em = $this->getDoctrine()->getManager();

		if(in_array("ROLE_ADMIN", $user->getRoles())){
			$role = "Administrator";
		}elseif (in_array("ROLE_AUTHOR", $user->getRoles()) 
			  && in_array("ROLE_MODERATOR", $user->getRoles())){
			$role = "Auteur, Moderator";
		}elseif (in_array("ROLE_AUTHOR", $user->getRoles())){
			$role = "Author";
		}elseif (in_array("ROLE_MODERATOR", $user->getRoles())){
			$role = "Moderator";
		}elseif (in_array("ROLE_USER", $user->getRoles())){
			$role = "User";
		}

		$category_rep        = $em->getRepository('WnBlogBundle:Category');
		$category_event      = $category_rep->myFindByName("Event");
		$category_chronic    = $category_rep->myFindByName("Chronic");
		$category_tutorial   = $category_rep->myFindByName("Tutorial");

		$article_rep        = $em->getRepository('WnBlogBundle:Article');
		$events             = $article_rep->findByAuthorAndCategory($user, $category_event);
		$list_chronic       = $article_rep->findByAuthorAndCategory($user, $category_chronic);
		$tutorials          = $article_rep->findByAuthorAndCategory($user, $category_tutorial);

		$comments = $em->getRepository('WnBlogBundle:Comment')
				       ->findLastNByAuthor($user, 5);

		
		return $this->render('WnBlogBundle:User:profile.html.twig', array(
			'user'          => $user,
			'role'          => $role,
			'comments'      => $comments,
			'events'        => $events,
			'list_chronic'  => $list_chronic,
			'tutorials'     => $tutorials
		));
	}

	public function loginAction()
	{
		return $this->render('WnBlogBundle:User:login.html.twig');
	}
}