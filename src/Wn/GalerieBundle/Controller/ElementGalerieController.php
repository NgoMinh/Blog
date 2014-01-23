<?php

namespace Wn\GalerieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Wn\GalerieBundle\Entity\ElementGalerie;
use Wn\BlogBundle\Entity\Commentaire;

use Wn\BlogBundle\Form\CommentaireType;

class ElementGalerieController extends Controller
{
	public function voirAction(ElementGalerie $elementGalerie){
		$em = $this->getDoctrine()
		           ->getManager();

		$commentaires = $em->getRepository('WnBlogBundle:Commentaire')
		                   ->findByIdElementOrderByDate($elementGalerie->getId());

		$commentaire = new Commentaire;
		$commentaire->setAuteur($this->getUser());
		$commentaire->setElement($elementGalerie);
		$form = $this->createForm(new CommentaireType,$commentaire);

		$request = $this->getRequest();

		if($request == "POST"){
			$form->bind($request);
			if($form->isValid()){
				$em->persist();
				$em->flush();

				return $this->redirect($this->generateUrl('wn_image_voir',array(
					'id'=>$elementGalerie
				)));
			}
		}


		return $this->render('WnGalerieBundle:ElementGalerie:voir.html.twig',array(
			'image'        => $elementGalerie,
			'commentaires' => $commentaires,
			'form'         => $form->createView()
		));
	}

	public function elementIndexAction(ElementGalerie $elementGalerie){
		return $this->render("WnGalerieBundle:ElementGalerie:elementIndex.html.twig",array(
			'elementGalerie' => $elementGalerie
		));
	}
}