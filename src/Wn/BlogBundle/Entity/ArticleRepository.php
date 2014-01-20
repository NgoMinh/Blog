<?php

namespace Wn\BlogBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends EntityRepository
{
	public function myFindAllOrderByDate()
	{
		$qb = $this->_em->createQueryBuilder();

		$qb->select('a')
		   ->from('WnBlogBundle:Article', 'a')
		   ->orderBy('a.datePublication','DESC');

		return $qb->getQuery()
				  ->getResult();
	}

	public function findByCategorie($categorie)
	{
		$qb = $this->_em->createQueryBuilder();
		$qb->select('a')
		   ->from('WnBlogBundle:Article', 'a')
		   ->where('a.categorie = :categorie')
		    ->setParameter('categorie', $categorie)
		   ->orderBy('a.datePublication','DESC');

	    return $qb->getQuery()
	              ->getResult();
	}

	public function findByAuteurAndCategorie($auteur, $categorie)
	{
		$qb = $this->_em->createQueryBuilder();
		$qb->select('a')
		   ->from('WnBlogBundle:Article','a')
		   ->where('a.categorie = :categorie')
		    ->setParameter('categorie', $categorie)
		   ->andWhere('a.auteur = :auteur')
		    ->setParameter('auteur', $auteur)
		   ->orderBy('a.datePublication','DESC');

		return $qb->getQuery()
		          ->getResult();
	}

	public function findLastNStartAtXByCategorie($valueMax, $valueStart, $categorie)
	{
		$qb = $this->_em->createQueryBuilder();
		$qb->select('a')
		   ->from('WnBlogBundle:Article','a')
		   ->where('a.categorie = :categorie')
		    ->setParameter('categorie', $categorie)
		   ->orderBy('a.datePublication','DESC')
		   ->setFirstResult($valueStart)
		   ->setMaxResults($valueMax);

		return $qb->getQuery()
		          ->getResult();
	}
}
