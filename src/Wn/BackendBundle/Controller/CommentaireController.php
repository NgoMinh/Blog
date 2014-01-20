<?php

namespace Wn\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Wn\BlogBundle\Entity\Commentaire;
use Wn\BlogBundle\Form\CommentaireType;

class CommentaireController extends Controller
{
	public function censurerAction(Commentaire $commentaire){
		return $this->render('WnBackendBundle:Commentaire:censurer.html.twig');
	}

	public function supprimerAction(Commentaire $commentaire){
		return $this->render('WnBackendBundle:Commentaire:supprimer.html.twig');
	}
}