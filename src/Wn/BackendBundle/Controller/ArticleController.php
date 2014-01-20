<?php

namespace Wn\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Wn\BlogBundle\Entity\Article;
use Wn\BlogBundle\Form\ArticleType;
use Wn\BlogBundle\Form\ArticleEditType;

class ArticleController extends Controller
{
	public function ajouterAction()
	{
		$article = new Article;
		$form = $this->createForm(new ArticleType, $article);

		$request = $this->getRequest();
		$article->setAuteur($this->getUser());

		if($request->getMethod() == 'POST'){
			$form->bind($request);
			if($form->isValid()){
				$entity_manager = $this->getDoctrine()->getManager();
				$entity_manager->persist($article);
				$entity_manager->flush();

				return $this->redirect($this->generateUrl('wn_backend_article'));
			}
		}

		return $this->render('WnBackendBundle:Article:ajouter.html.twig', array(
			'form' => $form->createView()
		));
	}

	public function editerAction(Article $article)
	{
		$form    = $this->createForm(new ArticleEditType, $article);
		$request = $this->getRequest();
		if($request->getMethod() == 'POST'){
			$form->bind($request);
			if($form->isValid()){
				$entity_manager = $this->getDoctrine()->getManager();
				$entity_manager->persist($article);
				$entity_manager->flush();

				return $this->redirect($this->generateUrl('wn_backend_article'));
			}
		} 
		return $this->render('WnBackendBundle:Article:editer.html.twig', array(
			'form'    => $form->createView(),
			'article' => $article
		));
	}

	public function supprimerAction(Article $article)
	{
		$form = $this->createFormBuilder()->getForm();
		$request = $this->getRequest();
		if($request->getMethod() == "POST"){
			$form->bind($request);
			if($form->isValid()){
				$entity_manager = $this->getDoctrine()->getManager();
				$entity_manager->remove($article);
				$entity_manager->flush();

				return $this->redirect($this->generateUrl('wn_backend_article'));
			}
		}
		
		return $this->render('WnBackendBundle:Article:supprimer.html.twig', array(
			'article' => $article,
			'form'    => $form->createView()
		));
	}
}