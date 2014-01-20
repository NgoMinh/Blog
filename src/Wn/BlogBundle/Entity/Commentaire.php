<?php

namespace Wn\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Wn\BlogBundle\Entity\CommentaireRepository")
 */
class Commentaire
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Wn\UserBundle\Entity\User", inversedBy="commentaires")
     */
    private $auteur;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;

    /**
     * @var boolean
     *
     * @ORM\Column(name="censure", type="boolean")
     */
    private $censure;

    /**
     * @ORM\ManyToOne(targetEntity="Wn\BlogBundle\Entity\Element", inversedBy="commentaires")
     */
    private $element;

    public function __construct()
    {
        $this->date = new \Datetime;
        $this->censure = false;
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
     * Set date
     *
     * @param \DateTime $date
     * @return Commentaire
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     * @return Commentaire
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
    
        return $this;
    }

    /**
     * Get contenu
     *
     * @return string 
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set censure
     *
     * @param boolean $censure
     * @return Commentaire
     */
    public function setCensure($censure)
    {
        $this->censure = $censure;
    
        return $this;
    }

    /**
     * Get censure
     *
     * @return boolean 
     */
    public function getCensure()
    {
        return $this->censure;
    }

    /**
     * Set auteur
     *
     * @param \Wn\UserBundle\Entity\User $auteur
     * @return Commentaire
     */
    public function setAuteur(\Wn\UserBundle\Entity\User $auteur = null)
    {
        $this->auteur = $auteur;
    
        return $this;
    }

    /**
     * Get auteur
     *
     * @return \Wn\UserBundle\Entity\User 
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set element
     *
     * @param \Wn\BlogBundle\Entity\Element $element
     * @return Commentaire
     */
    public function setElement(\Wn\BlogBundle\Entity\Element $element = null)
    {
        $this->element = $element;
        $element->addCommentaire($this);
        return $this;
    }

    /**
     * Get element
     *
     * @return \Wn\BlogBundle\Entity\Element 
     */
    public function getElement()
    {
        return $this->element;
    }
}