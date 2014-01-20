<?php

namespace Wn\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Wn\BlogBundle\Entity\Element;
/**
 * Article
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Wn\BlogBundle\Entity\ArticleRepository")
 */
class Article extends Element
{

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime")
     */
    private $dateCreation;

    /**
     * @var string
     * @ORM\Column(name="titre", type="text")
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="synopsis", type="text")
     */
    private $synopsis;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;

    /**
     * @var boolean
     *
     * @ORM\Column(name="publie", type="boolean")
     */
    private $publie;

    /**
     * @ORM\OneToOne(targetEntity="Wn\BlogBundle\Entity\ImageAffiche", cascade={"persist","remove"})
     */
    private $imageAffiche;

    /**
     * @ORM\ManyToOne(targetEntity="Wn\BlogBundle\Entity\Categorie", inversedBy="articles")
     */
    private $categorie;

    public function __construct()
    {
        $this->commentaires = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dateCreation = new \Datetime;
        $this->setDatePublication(new \Datetime);
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     * @return Article
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
    
        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime 
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }
    
    /**
     * Set synopsis
     *
     * @param string $synopsis
     * @return Article
     */
    public function setSynopsis($synopsis)
    {
        $this->synopsis = $synopsis;
    
        return $this;
    }

    /**
     * Get synopsis
     *
     * @return string 
     */
    public function getSynopsis()
    {
        return $this->synopsis;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     * @return Article
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
     * Set publie
     *
     * @param boolean $publie
     * @return Article
     */
    public function setPublie($publie)
    {
        $this->publie = $publie;
    
        return $this;
    }

    /**
     * Get publie
     *
     * @return boolean 
     */
    public function getPublie()
    {
        return $this->publie;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Article
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    
        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    public function getImageAffiche()
    {
        return $this->imageAffiche;
    }

    /**
     * Set imageAffiche
     *
     * @param \Wn\BlogBundle\Entity\ImageAffiche $imageAffiche
     * @return Article
     */
    public function setImageAffiche(\Wn\BlogBundle\Entity\ImageAffiche $imageAffiche = null)
    {
        $this->imageAffiche = $imageAffiche;
    
        return $this;
    }

    /**
     * Set categorie
     *
     * @param \Wn\BlogBundle\Entity\Categorie $categorie
     * @return Article
     */
    public function setCategorie(\Wn\BlogBundle\Entity\Categorie $categorie = null)
    {
        $this->categorie = $categorie;
    
        return $this;
    }

    /**
     * Get categorie
     *
     * @return \Wn\BlogBundle\Entity\Categorie 
     */
    public function getCategorie()
    {
        return $this->categorie;
    }
}