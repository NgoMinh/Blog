<?php

namespace Wn\BlogBundle\Twig;

use Wn\BlogBundle\Entity\Article;
use Wn\GalleryBundle\Entity\ImageGallery;
use Wn\Model3DBundle\Entity\Model3D;

class BlogExtension extends \Twig_Extension
{
	public function getTests()
	{
		return array(
			'wn_article'        => new \Twig_Test_Method($this, 'isArticle'),
			'wn_imageGallery'   => new \Twig_Test_Method($this, 'isImageGallery'),
			'wn_model3d'        => new \Twig_Test_Method($this, 'isModel3D')
		);
	}

	public function isArticle($element)
	{
		return ($element instanceof Article);
	}

	public function isImageGallery($element)
	{
		return ($element instanceof ImageGallery);
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