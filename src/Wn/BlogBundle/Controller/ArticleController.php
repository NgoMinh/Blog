<?php

namespace Wn\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Wn\BlogBundle\Entity\Article;
use Wn\BlogBundle\Entity\Commentaire;

use Wn\BlogBundle\Form\CommentaireType;

class ArticleController extends Controller
{
	public function voirAction(Article $article)
	{
		$entity_manager = $this->getDoctrine()
							   ->getManager();
							   
		$commentaires = $entity_manager->getRepository('WnBlogBundle:Commentaire')->findByIdElement($article->getId());

		$commentaire = new Commentaire;
		$commentaire->setAuteur($this->getUser());
		$commentaire->setElement($article);
		$form        = $this->createForm(new CommentaireType, $commentaire);

		$request = $this->getRequest();
		if($request->getMethod() == "POST"){
			$form->bind($request);
			if($form->isValid()){
				$entity_manager->persist($commentaire);
				$entity_manager->flush();

				return $this->redirect($this->generateUrl('wn_blog_article_voir', array(
					'id' => $article->getId()
				)));
			}
		}

		return $this->render('WnBlogBundle:Article:voir.html.twig',array(
			'article'      => $article,
			'commentaires' => $commentaires,
			'form'         => $form->createView()
		));
	}

	public function elementIndexAction(Article $article){
		return $this->render('WnBlogBundle:Article:ElementIndex.html.twig',array(
			'article' => $article
		));
	}

	public function menuAction(){
		$categories = $this->getDoctrine()
						   ->getManager()
						   ->getRepository('WnBlogBundle:Categorie')
						   ->findAll();
		return $this->render('WnBlogBundle:Article:menu.html.twig', array(
			'categories' => $categories
		));
	}
}