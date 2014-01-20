<?php

namespace Wn\Model3DBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Wn\Model3DBundle\Entity\Model3D;

class Model3DController extends Controller
{
	public function elementIndexAction(Model3D $model){
		
		return $this->render('WnModel3DBundle:Model3D:elementIndex.html.twig', array(
			'model' => $model
		));
	}
}