<?php

namespace Wn\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Wn\BlogBundle\Entity\Category;

use Wn\BlogBundle\Form\CategoryType;

class CategoryController extends Controller{
	/**
	 * render the page for adding a category
	 */
	public function addAction()
	{
		$category = new Category;
		$form     = $this->createForm(new CategoryType, $category);
		$request  = $this->getRequest();

		if( $request->getMethod() == "POST" )
		{
			$form->bind($request);
			if( $form->isValid() )
			{
				$em = $this->getDoctrine()->getManager();
				$em->persist($category);
				$em->flush();

				return $this->redirect( $this->generateUrl('wn_backend_category'));
			}
		}

		return $this->render('WnBackendBundle:Category:add.html.twig', array(
			'form' => $form->createView()
		));
	}

	/**
	 * render the confirmation page to delete a category
	 */
	public function deleteAction(Category $category)
	{
		$form    = $this->createFormBuilder()->getForm();
		$request = $this->getRequest();
		if($request->getMethod() == "POST")
		{
			$form->bind($request);
			if($form->isValid())
			{
				$em = $this->getDoctrine()->getManager();
				$em->remove($category);
				$em->flush();

				return $this->redirect($this->generateUrl('wn_backend_category'));
			}
		}

		return $this->render('WnBackendBundle:Category:delete.html.twig', array(
			'form' => $form->createView()
		));
	}

	/**
	 * render the edit page of a category
	 */
	public function editAction(Category $category)
	{
		$form    = $this->createForm(new CategoryType, $category);
		$request = $this->getRequest();

		if( $request->getMethod() == "POST" )
		{
			$form->bind($request);
			if( $form->isValid() )
			{
				$em = $this->getDoctrine()->getManager();
				$em->persist($category);
				$em->flush();

				return $this->redirect($this->generateUrl('wn_backend_category'));
			}
		}

		return $this->render('WnBackendBundle:Category:edit.html.twig', array(
			'form'     => $form->createView(),
			'category' => $category
		));
	}
}