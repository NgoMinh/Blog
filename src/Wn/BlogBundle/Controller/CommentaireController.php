<?php

namespace Wn\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CommentaireController extends Controller
{
	public function censurerAction(Commentaire $commentaire){
		return $this->render('WnBackendBundle:Commentaire:censurer.html.twig');
	}

	public function supprimerAction(Commentaire $commentaire){
		return $this->render('WnBackendBundle:Commentaire:supprimer.html.twig');
	}
}