<?php

namespace Wn\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Wn\Model3DBundle\Entity\Model3D;
use Wn\Model3DBundle\Form\Model3DType;
use Wn\Model3DBundle\Form\Model3DConfigType;

class Model3DController extends Controller
{
	public function ajouterAction()
	{
		$model = new Model3D;
		$form = $this->createForm(new Model3DType , $model);
		$request = $this->getRequest();
		$model->setAuteur($this->getUser());
		if($request->getMethod() == 'POST'){
			$form->bind($request);
			if($form->isValid()){
				$entity_manager = $this->getDoctrine()
									   ->getManager();

				$entity_manager->persist($model);
				$entity_manager->flush();

				return $this->redirect($this->generateUrl('wn_backend_model_config',array('id'=>$model->getId())));
			}
		}
		return $this->render('WnBackendBundle:Model3D:ajouter.html.twig', array(
			'form' => $form->createView()
		));
	}

	public function editerAction()
	{
		return $this->render('WnBackendBundle:Model3D:editer.html.twig');
	}

	public function supprimerAction(Model3D $model)
	{
		$form    = $this->createFormBuilder()->getForm();
		$request = $this->getRequest();
		if($request->getMethod() == 'POST'){
			$form->bind($request);
			if($form->isValid()){
				$entity_manager = $this->getDoctrine()->getManager();
				$entity_manager->remove($model);
				$entity_manager->flush();

				return $this->redirect($this->generateUrl('wn_backend_model'));
			}
		}
		return $this->render('WnBackendBundle:Model3D:supprimer.html.twig', array(
			'form' => $form->createView()
		));
	}

	public function configAction(Model3D $model)
	{
		$form = $this->createForm(new Model3DConfigType, $model);
		$request = $this->getRequest();
		if($request->getMethod() =='POST'){
			$form->bind($request);
			if($form->isValid()){
				$entity_manager = $this->getDoctrine()->getManager();
				$entity_manager->persist($model);
				$entity_manager->flush();

				return $this->redirect($this->generateUrl('wn_backend_model'));
			}
		}
		return $this->render('WnBackendBundle:Model3D:config.html.twig', array(
			'form'  => $form->createView(),
			'model' => $model
		));
	}
}