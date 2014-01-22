<?php

namespace Wn\BlogBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CommentaireRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentaireRepository extends EntityRepository
{
	public function findByIdElement($id_element){
		$qb = $this->createQueryBuilder('c')
		           ->where('c.element = :id')
	      			->setParameter('id', $id_element);

		return $qb->getQuery()
		          ->getResult();
	}

	public function findByIdElementOrderByDate($id_element){
		$qb = $this->createQueryBuilder('c')
				   ->where('c.element = :id')
				    ->setParameter('id',$id_element)
				   ->orderBy('c.date','DESC');
		
		return $qb->getQuery()
				  ->getResult();
	}

	public function findLastNByAuteur($auteur, $value){
		$qb = $this->createQueryBuilder('c')
		           ->where('c.auteur = :auteur')
		            ->setParameter('auteur', $auteur)
		           ->orderBy('c.date', 'DESC')
		           ->setMaxResults($value);

		return $qb->getQuery()
		          ->getResult();
	}
}
