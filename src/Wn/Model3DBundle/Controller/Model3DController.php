<?php

namespace Wn\Model3DBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Wn\Model3DBundle\Entity\Model3D;

use Wn\BlogBundle\Entity\Commentaire;
use Wn\BlogBundle\Form\CommentaireType;

class Model3DController extends Controller
{
	public function voirAction(Model3D $model){
		$em = $this->getDoctrine()
		           ->getManager();

		$commentaires = $em->getRepository('WnBlogBundle:Commentaire')
		                   ->findByIdElementOrderByDate($model);

		$commentaire = new Commentaire;
		$commentaire->setAuteur($this->getUser());
		$commentaire->setElement($model);
		$form = $this->createForm(new CommentaireType, $commentaire);
		$request = $this->getRequest();
		
		if($request == "POST"){
			$form->bind($request);
			if($form->isValid()){
				$em->persist($commentaire);
				$em->flush();

				return $this->redirect($this->generateUrl('wn_model3D_voir',array(
					'id' => $model->getId()
				)));
			}
		}

		return $this->render('WnModel3DBundle:Model3D:voir.html.twig',array(
			'form'         => $form->createView(),
			'commentaires' => $commentaires,
			'model'        => $model
		));
	}
		
	public function elementIndexAction(Model3D $model){
		
		return $this->render('WnModel3DBundle:Model3D:elementIndex.html.twig', array(
			'model' => $model
		));
	}
}