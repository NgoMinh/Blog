<?php

namespace Wn\GalleryBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ImageGalleryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ImageGalleryRepository extends EntityRepository
{
	public function findLastNStartAtX($valueMax, $valueStart){
		$qb = $this->_em->createQueryBuilder();
		$qb->select('e')
		   ->from('WnGalleryBundle:ElementGallery','e')
		   ->orderBy('e.datePublication','DESC')
		   ->setFirstResult($valueStart)
		   ->setMaxResults($valueMax);

		return $qb->getQuery()
		          ->getResult();
	}
}