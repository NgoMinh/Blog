<?php

namespace Wn\Model3DBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Wn\Model3DBundle\Entity\Model3D;
use Wn\BlogBundle\Entity\Comment;

use Wn\Model3DBundle\Form\Model3DType;
use Wn\Model3DBundle\Form\Model3DConfigType;
use Wn\BlogBundle\Form\CommentType;

class Model3DController extends Controller
{
	public function viewAction(Model3D $model){
		return $this->render('WnModel3DBundle:Model3D:view.html.twig',array(
			'model'        => $model
		));
	}

	public function addAction()
	{
		$model   = new Model3D;
		$model->setAuthor($this->getUser());
		$form    = $this->createForm(new Model3DType , $model);
		$request = $this->getRequest();
		
		if($request->getMethod() == 'POST'){
			$form->bind($request);
			if($form->isValid()){
				$em = $this->getDoctrine()->getManager();
				$em->persist($model);
				$em->flush();

				return $this->redirect($this->generateUrl('wn_backend_model_config',array('id'=>$model->getId())));
			}
		}
		return $this->render('WnBackendBundle:Model3D:add.html.twig', array(
			'form' => $form->createView()
		));
	}

	public function editAction()
	{
		return $this->render('WnBackendBundle:Model3D:edit.html.twig');
	}

	public function deleteAction(Model3D $model)
	{
		$form    = $this->createFormBuilder()->getForm();
		$request = $this->getRequest();
		
		if($request->getMethod() == 'POST'){
			$form->bind($request);
			if($form->isValid()){
				$em = $this->getDoctrine()->getManager();
				$em->remove($model);
				$em->flush();

				return $this->redirect($this->generateUrl('wn_backend_model'));
			}
		}
		return $this->render('WnBackendBundle:Model3D:delete.html.twig', array(
			'form' => $form->createView()
		));
	}

	public function configAction(Model3D $model)
	{
		$form    = $this->createForm(new Model3DConfigType, $model);
		$request = $this->getRequest();

		if($request->getMethod() =='POST'){
			$form->bind($request);
			if($form->isValid()){
				$em = $this->getDoctrine()->getManager();
				$em->persist($model);
				$em->flush();

				return $this->redirect($this->generateUrl('wn_backend_model'));
			}
		}
		return $this->render('WnBackendBundle:Model3D:config.html.twig', array(
			'form'  => $form->createView(),
			'model' => $model
		));
	}
		
	public function viewOnHomepageAction(Model3D $model){
		
		return $this->render('WnModel3DBundle:Model3D:viewOnHomepage.html.twig', array(
			'model' => $model
		));
	}
}