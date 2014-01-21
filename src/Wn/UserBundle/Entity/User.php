<?php

namespace Wn\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="wn_user")
 */
class User extends BaseUser
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\OneToMany(targetEntity="Wn\BlogBundle\Entity\Commentaire" , mappedBy="auteur")
	 */
	private $commentaires;

    /**
     * @ORM\OneToMany(targetEntity="Wn\BlogBundle\Entity\Element", mappedBy="auteur")
     */
    private $elements;

	public function __construct(){
		parent::__construct();
        $elements     = new \Doctrine\Common\Collections\ArrayCollection();
		$commentaires = new \Doctrine\Common\Collections\ArrayCollection();
	    $this->roles  = array('ROLE_USER');
    }

    /**
     * Add commentaires
     *
     * @param \Wn\BlogBundle\Entity\Commentaire $commentaires
     * @return User
     */
    public function addCommentaire(\Wn\BlogBundle\Entity\Commentaire $commentaires)
    {
        $this->commentaires[] = $commentaires;
    
        return $this;
    }

    /**
     * Remove commentaires
     *
     * @param \Wn\BlogBundle\Entity\Commentaire $commentaires
     */
    public function removeCommentaire(\Wn\BlogBundle\Entity\Commentaire $commentaires)
    {
        $this->commentaires->removeElement($commentaires);
    }

    /**
     * Get commentaires
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add elements
     *
     * @param \Wn\BlogBundle\Entity\Element $elements
     * @return User
     */
    public function addElement(\Wn\BlogBundle\Entity\Element $elements)
    {
        $this->elements[] = $elements;
    
        return $this;
    }

    /**
     * Remove elements
     *
     * @param \Wn\BlogBundle\Entity\Element $elements
     */
    public function removeElement(\Wn\BlogBundle\Entity\Element $elements)
    {
        $this->elements->removeElement($elements);
    }

    /**
     * Get elements
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getElements()
    {
        return $this->elements;
    }
}