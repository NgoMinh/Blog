<?php

namespace Wn\GalerieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Wn\GalerieBundle\Entity\ElementGalerie;
use Wn\BlogBundle\Entity\Commentaire;

use Wn\GalerieBundle\Form\ElementGalerieType;
use Wn\BlogBundle\Form\CommentaireType;

class ElementGalerieController extends Controller
{
	public function ajouterAction(){

		$entity_manager = $this->getDoctrine()->getManager();
		$galerie        = $entity_manager->getRepository('WnGalerieBundle:Galerie')->findByNom('Galerie principale');
		$elementGalerie = new ElementGalerie;
		$form           = $this->createForm(new ElementGalerieType, $elementGalerie);
		$elementGalerie->setAuteur($this->getUser());
		$elementGalerie->setGalerie($galerie);

		$request = $this->getRequest();
		if($request->getMethod() == 'POST'){
			$form->bind($request);
			if($form->isValid()){
				$entity_manager->persist($elementGalerie);
				$entity_manager->flush();

				return $this->redirect($this->generateUrl('wn_backend_galerie'));
			}
		}

		return $this->render('WnBackendBundle:Galerie:ajouter.html.twig', array(
			'form'=> $form->createView()
		));
	}

	public function supprimerAction(ElementGalerie $elementGalerie){
		$form = $this->createFormBuilder()->getForm();
		$request = $this->getRequest();
		if($request->getMethod() == "POST"){
			$form->bind($request);
			if($form->isValid()){
				$entity_manager = $this->getDoctrine()
				                       ->getManager();
				$entity_manager->remove($elementGalerie);
				$entity_manager->flush();

				return $this->redirect($this->generateUrl('wn_backend_galerie'));
			}
		}

		return $this->render('WnBackendBundle:Galerie:supprimer.html.twig', array(
			'form'    => $form->createView(),
			'element' => $elementGalerie
		));
	}

	public function modifierAction(ElementGalerie $elementGalerie){
		$form = $this->createForm(new ElementGalerieType, $elementGalerie);
		$request = $this->getRequest();

		if($request->getMethod() == "POST"){
			$form->bind($request);
			if($form->isValid()){
				$entity_manager = $this->getDoctrine()
									   ->getManager();
				$entity_manager->persist($elementGalerie);
				$entity_manager->flush();

				return $this->redirect($this->generateUrl('wn_backend_galerie'));
			}
		}
		return $this->render('WnBackendBundle:Galerie:modifier.html.twig',array(
			'form'    => $form->createView(),
			'element' => $elementGalerie
		));
	}
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