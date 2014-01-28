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
	 * @ORM\OneToMany(targetEntity="Wn\BlogBundle\Entity\Comment" , mappedBy="author")
	 */
	private $comments;

    /**
     * @ORM\OneToMany(targetEntity="Wn\BlogBundle\Entity\Element", mappedBy="author")
     */
    private $elements;

	public function __construct(){
		parent::__construct();
        $elements     = new \Doctrine\Common\Collections\ArrayCollection();
		$comments     = new \Doctrine\Common\Collections\ArrayCollection();
	    $this->roles  = array('ROLE_USER');
    }

    /**
     * Add comments
     *
     * @param \Wn\BlogBundle\Entity\Comment $comments
     * @return User
     */
    public function addComment(\Wn\BlogBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;
    
        return $this;
    }

    /**
     * Remove comments
     *
     * @param \Wn\BlogBundle\Entity\Comment $comments
     */
    public function removeComment(\Wn\BlogBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
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