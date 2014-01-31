<?php

namespace Wn\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Wn\BlogBundle\Entity\Article;
use Wn\BlogBundle\Entity\Comment;
use Wn\BlogBundle\Entity\Element;
use Wn\GalleryBundle\Entity\ImageGallery;
use Wn\Model3DBundle\Entity\Model3D;


use Wn\BlogBundle\Form\CommentType;

class CommentController extends Controller
{
	public function viewOnElementAction(Element $element){
		$em = $this->getDoctrine()
		           ->getManager();

		$comment  = new comment;
		$comment->setAuthor($this->getUser());
		$comment->setElement($element);
		$comments = $em->getRepository('WnBlogBundle:comment')
		               ->findByIdElementOrderByDate($element->getId());
		$form     = $this->createForm(new CommentType, $comment);
		$request  = $this->getRequest();
		if($request->getMethod() == "POST"){
			$form->bind($request);
			if($form->isValid()){
				$em->persist($comment);
				$em->flush();

				if($element instanceof Article){
					$route = 'wn_blog_article_view';
				}elseif($element instanceof Model3D){
					$route = 'wn_model3D_view';
				}elseif($element instanceof ImageGallery){
					$route = 'wn_gallery_image_view';
				}

				return $this->redirect($this->generateUrl($route, array(
					'id' => $element->getId()
				)));
			}
		}

		return $this->render('WnBlogBundle:Comment:view.html.twig',array(
			'element'      => $element,
			'form'         => $form->createView(),
			'comments'     => $comments,
			'comment'      => $comment
			));
	}

	public function censorAction(comment $comment){
		$form    = $this->createFormBuilder()->getForm();
		$request = $this->getRequest();
		
		if($request->getMethod() == 'POST')
		{
			$form->bind($request);
			if($form->isValid())
			{
				$em = $this->getDoctrine()->getManager();
				$comment->setCensored(true);
				$em->persist($comment);
				$em->flush();

				return $this->redirect($this->generateUrl('wn_backend_comment'));
			}
		}

		return $this->render('WnBackendBundle:Comment:censor.html.twig',array(
			'form'    => $form->createView(),
			'comment' => $comment
			));
	}

	public function uncensorAction(comment $comment)
	{
		$form    = $this->createFormBuilder()->getForm();
		$request = $this->getRequest();

		if($request->getMethod() == 'POST')
		{
			$form->bind($request);
			if($form->isValid())
			{
				$em = $this->getDoctrine()->getManager();
				$comment->setCensored(false);
				$em->persist($comment);
				$em->flush();

				return $this->redirect($this->generateUrl('wn_backend_comment'));
			}
		}

		return $this->render('WnBackendBundle:Comment:uncensor.html.twig', array(
			'form'    => $form->createView(),
			'comment' => $comment
		));
	}

	public function deleteAction(comment $comment){
		return $this->render('WnBackendBundle:Comment:delete.html.twig');
	}
}