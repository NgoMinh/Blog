<?php

namespace Wn\BlogBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CategorieRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends EntityRepository
{
	/**
	 * Find a category by his name
	 * 
	 * @param  string $name
	 * @return result
	 */
	public function myFindByName($name){
		$qb = $this->_em->createQueryBuilder();

		$qb->select('c')
		   ->from('WnBlogBundle:Category','c')
		   ->where('c.name = :name')
		    ->setParameter('name', $name);

		return $qb->getQuery()
		          ->getResult();
	}
}
