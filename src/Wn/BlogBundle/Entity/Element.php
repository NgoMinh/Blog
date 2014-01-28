<?php

namespace Wn\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Element
 * 
 * @ORM\Entity(repositoryClass="Wn\BlogBundle\Entity\ElementRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"element" = "Element", "article" = "Article", "imagegallery" = "Wn\GalleryBundle\Entity\ImageGallery", "model3d" = "Wn\Model3DBundle\Entity\Model3D" })
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
     * @ORM\Column(name="dateOfPublication", type="datetime")
     */
    private $dateOfPublication;

    /**
     * @ORM\OneToMany(targetEntity="Wn\BlogBundle\Entity\Comment", mappedBy="element", cascade={"remove"})
     */
    private $comments;

    /**
     * @ORM\ManyToOne(targetEntity="Wn\UserBundle\Entity\User", inversedBy="elements")
     */
    private $author;


    public function __construct(){
              $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set dateOfPublication
     *
     * @param \DateTime $dateOfPublication
     * @return Element
     */
    public function setDateOfPublication($dateOfPublication)
    {
        $this->dateOfPublication = $dateOfPublication;
    
        return $this;
    }

    /**
     * Get dateOfPublication
     *
     * @return \DateTime 
     */
    public function getDateOfPublication()
    {
        return $this->dateOfPublication;
    }

    /**
     * Add comments
     *
     * @param \Wn\BlogBundle\Entity\Comment $comments
     * @return Element
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
     * Set author
     *
     * @param \Wn\UserBundle\Entity\User $author
     * @return Element
     */
    public function setAuthor(\Wn\UserBundle\Entity\User $author = null)
    {
        $this->author = $author;
        $author->addElement($this);
        return $this;
    }

    /**
     * Get author
     *
     * @return \Wn\UserBundle\Entity\User 
     */
    public function getAuthor()
    {
        return $this->author;
    }
}