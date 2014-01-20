<?php

namespace Wn\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Element
 * 
 * @ORM\Entity(repositoryClass="Wn\BlogBundle\Entity\ElementRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"element" = "Element", "article" = "Article", "elementgalerie" = "Wn\GalerieBundle\Entity\ElementGalerie", "model3d" = "Wn\Model3DBundle\Entity\Model3D" })
 */
class Element
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
     * @var \DateTime
     *
     * @ORM\Column(name="datePublication", type="datetime")
     */
    private $datePublication;

    /**
     * @ORM\OneToMany(targetEntity="Wn\BlogBundle\Entity\Commentaire", mappedBy="element", cascade={"remove"})
     */
    private $commentaires;

    /**
     * @ORM\ManyToOne(targetEntity="Wn\UserBundle\Entity\User", inversedBy="elements")
     */
    private $auteur;


    public function __construct(){
              $this->commentaires = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set datePublication
     *
     * @param \DateTime $datePublication
     * @return Element
     */
    public function setDatePublication($datePublication)
    {
        $this->datePublication = $datePublication;
    
        return $this;
    }

    /**
     * Get datePublication
     *
     * @return \DateTime 
     */
    public function getDatePublication()
    {
        return $this->datePublication;
    }

    /**
     * Add commentaires
     *
     * @param \Wn\BlogBundle\Entity\Commentaire $commentaires
     * @return Element
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
     * Set auteur
     *
     * @param \Wn\UserBundle\Entity\User $auteur
     * @return Element
     */
    public function setAuteur(\Wn\UserBundle\Entity\User $auteur = null)
    {
        $this->auteur = $auteur;
        $auteur->addElement($this);
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
}