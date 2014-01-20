<?php

namespace Wn\GalerieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Galerie
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Wn\GalerieBundle\Entity\GalerieRepository")
 */
class Galerie
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="Wn\GalerieBundle\Entity\ElementGalerie", mappedBy="galerie", cascade={"remove"})
     */
    private $elements;


    public function getUploadDir()
    {
        return 'uploads/galerie/'.$this->getId().'-'.$this->getNom();
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
     * Set nom
     *
     * @param string $nom
     * @return Galerie
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    
        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->elements = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add elements
     *
     * @param \Wn\GalerieBundle\Entity\ElementGalerie $elements
     * @return Galerie
     */
    public function addElement(\Wn\GalerieBundle\Entity\ElementGalerie $elements)
    {
        $this->elements[] = $elements;
        return $this;
    }

    /**
     * Remove elements
     *
     * @param \Wn\GalerieBundle\Entity\ElementGalerie $elements
     */
    public function removeElement(\Wn\GalerieBundle\Entity\ElementGalerie $elements)
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