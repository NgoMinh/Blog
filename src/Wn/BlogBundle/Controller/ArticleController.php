<?php

namespace Wn\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Wn\BlogBundle\Entity\Article;

use Wn\BlogBundle\Form\ArticleType;
use Wn\BlogBundle\Form\ArticleEditType;

class ArticleController extends Controller
{
	/**
	 * render the page of adding article
	 */
	public function addAction()
	{
		$article = new Article;
		$form    = $this->createForm(new ArticleType, $article);
		$request = $this->getRequest();
		$article->setAuthor($this->getUser());
		if( $request->getMethod() == "POST" )
		{
			$form->bind($request);
			if( $form->isValid() )
			{
				$em = $this->getDoctrine()->getManager();
				$em->persist($article);
				$em->flush();

				return $this->redirect($this->generateUrl('wn_backend_article'));
			}
		}

		return $this->render('WnBackendBundle:Article:add.html.twig', array(
			'form' => $form->createView()
		));
	}

	/**
	 * render the edit page of an article
	 */
	public function editAction(Article $article)
	{
		$form    = $this->createForm(new ArticleEditType, $article);
		$request = $this->getRequest();
		if( $request->getMethod() == "POST")
		{
			$form->bind($request);
			if($form->isValid())
			{
				$em = $this->getDoctrine()->getManager();
				$em->persist($article);
				$em->flush();

				return $this->redirect($this->generateUrl('wn_backend_article'));
			}
		}

		return $this->render('WnBackendBundle:Article:edit.html.twig', array(
			'form' => $form->createView()
		));
	}

	/**
	 * render the confirmation for deleting an Article
	 */
	public function deleteAction(Article $article)
	{
		$form    = $this->createFormBuilder()->getForm();
		$request = $this->getRequest();
		if( $request->getMethod() == "POST" )
		{
			$form->bind($request);
			if($form->isValid())
			{
				$em = $this->getDoctrine()->getManager();
				$em->remove($article);
				$em->flush();

				return $this->redirect($this->generateUrl('wn_backend_article'));			
			}
		}

		return $this->render('WnBackendBundle:Article:delete.html.twig', array(
			'form'    => $form->createView(),
			'article' => $article
		));
	}

	/**
	 * render of an article
	 */
	public function viewAction(Article $article){
		return $this->render('WnBlogBundle:Article:view.html.twig', array(
			'article'       => $article
		));
	}

	/**
	 * render of an article on the index
	 */
	public function viewOnHomepageAction(Article $article)
	{
		return $this->render('WnBlogBundle:Article:viewOnHomepage.html.twig', array(
			'article' => $article
		));
	}
}