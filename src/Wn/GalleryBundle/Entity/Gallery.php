<?php

namespace Wn\GalleryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gallery
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Wn\GalleryBundle\Entity\GalleryRepository")
 */
class Gallery
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Wn\GalleryBundle\Entity\ImageGallery", mappedBy="gallery", cascade={"remove"})
     */
    private $images;


    public function getUploadDir()
    {
        return 'uploads/gallery/'.$this->getId().'-'.$this->getName();
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
     * Set name
     *
     * @param string $name
     * @return Gallery
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add images
     *
     * @param \Wn\GalleryBundle\Entity\ImageGallery $images
     * @return Gallery
     */
    public function addImage(\Wn\GalleryBundle\Entity\ImageGallery $images)
    {
        $this->images[] = $images;
        return $this;
    }

    /**
     * Remove images
     *
     * @param \Wn\GalleryBundle\Entity\ImageGallery $images
     */
    public function removeImage(\Wn\GalleryBundle\Entity\ImageGallery $images)
    {
        $this->images->removeImage($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }
}