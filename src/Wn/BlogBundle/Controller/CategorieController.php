<?php

namespace Wn\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Wn\BlogBundle\Entity\Categorie;

use Wn\BlogBundle\Form\CategorieType;

class CategorieController extends Controller{

	public function ajouterAction()
	{
		$categorie = new Categorie;
		$form = $this->createForm(new CategorieType, $categorie);

		$request = $this->getRequest();
		if($request->getMethod() == "POST"){
			$form->bind($request);
			if($form->isValid()){
				$entity_manager = $this->getDoctrine()->getManager();
				$entity_manager->persist($categorie);
				$entity_manager->flush();

				return $this->redirect($this->generateUrl('wn_backend_categorie'));
			}
		}

		return $this->render('WnBackendBundle:Categorie:ajouter.html.twig', array(
			'form' => $form->createView()
		));
	}

	public function supprimerAction(Categorie $categorie)
	{
		$form = $this->createFormBuilder()->getForm();
		$request = $this->getRequest();
		if($request->getMethod() == "POST"){
			$form->bind($request);
			if($form->isValid()){
				$entity_manager = $this->getDoctrine()->getManager();
				$entity_manager->remove($categorie);
				$entity_manager->flush();

				return $this->redirect($this->generateUrl('wn_backend_categorie'));
			}
		}

		return $this->render('WnBackendBundle:Categorie:supprimer.html.twig', array(
			'form' => $form->createView()
		));
	}

	public function editerAction(Categorie $categorie)
	{
		$form = $this->createForm(new CategorieType, $categorie);
		$request = $this->getRequest();

		if($request->getMethod() == "POST"){
			$form->bind($request);
			if($form->isValid()){
				$entity_manager = $this->getDoctrine()->getManager();
				$entity_manager->persist($categorie);
				$entity_manager->flush();

				return $this->redirect($this->generateUrl('wn_backend_categorie'));
			}
		}

		return $this->render('WnBackendBundle:Categorie:editer.html.twig', array(
			'categorie' => $categorie,
			'form'      => $form->createView()
		));
	}
}