<?php

namespace Wn\GalerieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Wn\GalerieBundle\Entity\ElementGalerie;

class ElementGalerieController extends Controller
{
	public function elementIndexAction(ElementGalerie $elementGalerie){
		return $this->render("WnGalerieBundle:ElementGalerie:elementIndex.html.twig",array(
			'elementGalerie' => $elementGalerie
		));
	}
}