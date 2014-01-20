<?php

namespace Wn\BlogBundle\Twig;

use Wn\BlogBundle\Entity\Article;
use Wn\GalerieBundle\Entity\ElementGalerie;
use Wn\Model3DBundle\Entity\Model3D;

class BlogExtension extends \Twig_Extension
{
	public function getTests()
	{
		return array(
			'wn_article'        => new \Twig_Test_Method($this, 'isArticle'),
			'wn_elementGalerie' => new \Twig_Test_Method($this, 'isElementGalerie'),
			'wn_model3d'        => new \Twig_Test_Method($this, 'isModel3D')
		);
	}

	public function isArticle($element)
	{
		return ($element instanceof Article);
	}

	public function isElementGalerie($element)
	{
		return ($element instanceof ElementGalerie);
	}

	public function isModel3D($element)
	{
		return ($element instanceof Model3D);
	}

	public function getName()
	{
		return 'blog_extension';
	}
}