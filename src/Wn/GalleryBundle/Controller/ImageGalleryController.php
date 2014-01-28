<?php

namespace Wn\GalleryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Wn\GalleryBundle\Entity\ImageGallery;
use Wn\BlogBundle\Entity\Commentaire;

use Wn\GalleryBundle\Form\ImageGalleryType;
use Wn\BlogBundle\Form\CommentaireType;

class ImageGalleryController extends Controller
{
	public function addAction(){

		$em           = $this->getDoctrine()->getManager();
		$gallery      = $em->getRepository('WnGalleryBundle:Gallery')->findByName('Main Gallery');
		$imageGallery = new ImageGallery;
		$imageGallery->setAuthor($this->getUser());
		$imageGallery->setGallery($gallery);
		$form         = $this->createForm(new ImageGalleryType, $imageGallery);
		$request      = $this->getRequest();

		if($request->getMethod() == 'POST'){
			$form->bind($request);
			if($form->isValid()){
				$em->persist($imageGallery);
				$em->flush();

				return $this->redirect($this->generateUrl('wn_backend_gallery'));
			}
		}

		return $this->render('WnBackendBundle:Gallery:add.html.twig', array(
			'form'=> $form->createView()
		));
	}

	public function deleteAction(ImageGallery $imageGallery){
		$form    = $this->createFormBuilder()->getForm();
		$request = $this->getRequest();
		if($request->getMethod() == "POST"){
			$form->bind($request);
			if($form->isValid()){
				$em = $this->getDoctrine()->getManager();
				$em->remove($imageGallery);
				$em->flush();

				return $this->redirect($this->generateUrl('wn_backend_gallery'));
			}
		}

		return $this->render('WnBackendBundle:Gallery:delete.html.twig', array(
			'form'  => $form->createView(),
			'image' => $imageGallery
		));
	}

	public function editAction(ImageGallery $imageGallery){
		$form    = $this->createForm(new ImageGalleryType, $imageGallery);
		$request = $this->getRequest();

		if($request->getMethod() == "POST"){
			$form->bind($request);
			if($form->isValid()){
				$em = $this->getDoctrine()->getManager();
				$em->persist($imageGallery);
				$em->flush();

				return $this->redirect($this->generateUrl('wn_backend_gallery'));
			}
		}
		return $this->render('WnBackendBundle:Gallery:edit.html.twig',array(
			'form'  => $form->createView(),
			'image' => $imageGallery
		));
	}
	public function viewAction(ImageGallery $image){
		return $this->render('WnGalleryBundle:ImageGallery:view.html.twig',array(
			'image'        => $image
		));
	}

	public function viewOnHomepageAction(ImageGallery $image){
		return $this->render("WnGalleryBundle:ImageGallery:viewOnHomepage.html.twig",array(
			'image' => $image
		));
	}
}