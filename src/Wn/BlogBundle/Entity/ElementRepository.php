<?php

namespace Wn\BlogBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ElementRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ElementRepository extends EntityRepository
{
	public function myFindAllOrderByDate(){
		$qb = $this->_em->createQueryBuilder();
		$qb->select('e')
		   ->from('WnBlogBundle:Element','e')
		   ->orderBy('e.dateOfPublication','DESC');

		return $qb->getQuery()
				  ->getResult();
	}

	public function findLastN($value){
		$qb = $this->_em->createQueryBuilder();
		$qb->select('e')
		   ->from('WnBlogBundle:Element','e')
		   ->orderBy('e.dateOfPublication','DESC')
		   ->setMaxResults($value);

		return $qb->getQuery()
		          ->getResult();
	}

	public function findLastNStartAtX($valueMax, $valueStart){
		$qb = $this->_em->createQueryBuilder();
		$qb->select('e')
		   ->from('WnBlogBundle:Element','e')
		   ->orderBy('e.dateOfPublication','DESC')
		   ->setFirstResult($valueStart)
		   ->setMaxResults($valueMax);

		return $qb->getQuery()
		          ->getResult();
	}

	public function findForUpdateHomepage($valueMax, $valueStart){
		
	}
}
