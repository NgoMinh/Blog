<?php

namespace Wn\BlogBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CommentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentRepository extends EntityRepository
{
	/**
	 * Find all comment from an element
	 *
	 * @param  integer $id_element
	 * @return result
	 */
	public function findByIdElement($id_element)
	{
		$qb = $this->createQueryBuilder('c')
		           ->where('c.element = :id')
	      			->setParameter('id', $id_element);

		return $qb->getQuery()
		          ->getResult();
	}

	/**
	 * Find All comment from an element ordered by date
	 * Used for the view of an element
	 * 
	 * @param interger $id_element 
	 * @return result
	 */
	public function findByIdElementOrderByDate($id_element)
	{
		$qb = $this->createQueryBuilder('c')
				   ->where('c.element = :id')
				    ->setParameter('id',$id_element)
				   ->orderBy('c.date','DESC');
		
		return $qb->getQuery()
				  ->getResult();
	}

	/**
	 * Find Last N comment of an author
	 * Used for the profile of an User
	 *
	 * @param   WnUserBundle/Entity/User $author Author comments
	 * @param   integer                  $value  Number of comment required
	 * @return  result
	 */
	public function findLastNByAuthor($author, $value)
	{
		$qb = $this->createQueryBuilder('c')
		           ->where('c.author = :author')
		            ->setParameter('author', $author)
		           ->orderBy('c.date', 'DESC')
		           ->setMaxResults($value);

		return $qb->getQuery()
		          ->getResult();
	}
}
