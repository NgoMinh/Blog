<?php

namespace Wn\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Wn\BlogBundle\Entity\Element;
use Wn\BlogBundle\Entity\Commentaire;

use Wn\BlogBundle\Form\CommentaireType;

class CommentaireController extends Controller
{
	public function viewOnElementAction(Element $element){
		$em = $this->getDoctrine()
		           ->getManager();

		$commentaire  = new Commentaire;
		$commentaire->setAuteur($this->getUser());
		$commentaire->setElement($element);
		$commentaires = $em->getRepository('WnBlogBundle:Commentaire')
		                   ->findByIdElementOrderByDate($element->getId());
		$form         = $this->createForm(new CommentaireType, $commentaire);
		$request      = $this->getRequest();
		if($request->getMethod() == "POST"){
			$form->bind($request);
			if($form->isValid()){
				$em->persist($commentaire);
				$em->flush();

				return $this->redirect($this->generateUrl('wn_blog_article_voir', array(
					'id' => $element->getId()
				)));
			}
		}

		return $this->render('WnBlogBundle:Commentaire:view.html.twig',array(
			'form'         => $form->createView(),
			'commentaires' => $commentaires,
			'commentaire'  => $commentaire
		));
	}

	public function censurerAction(Commentaire $commentaire){
		return $this->render('WnBackendBundle:Commentaire:censurer.html.twig');
	}

	public function supprimerAction(Commentaire $commentaire){
		return $this->render('WnBackendBundle:Commentaire:supprimer.html.twig');
	}
}