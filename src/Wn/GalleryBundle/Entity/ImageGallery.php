<?php

namespace Wn\GalleryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Wn\BlogBundle\Entity\Element;
/**
 * ImageGallery
 *
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Wn\GalleryBundle\Entity\ImageGalleryRepository")
 */
class ImageGallery extends Element
{

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="string", length=255)
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity="Wn\GalleryBundle\Entity\Gallery", inversedBy="elements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $gallery;

    /**
     * @var string 
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    private $file;
    private $tempFilename;

    public function __construct()
    {
        $this->setDateOfPublication(new \Datetime);
    }

    /**
     * Set title
     *
     * @param string $title
     * @return ImageGallery
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set note
     *
     * @param string $note
     * @return ImageGallery
     */
    public function setNote($note)
    {
        $this->note = $note;
    
        return $this;
    }

    /**
     * Get note
     *
     * @return string 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set gallery
     *
     * @param \Wn\GalleryBundle\Entity\Gallery $gallery
     * @return ImageGallery
     */
    public function setGallery(\Wn\GalleryBundle\Entity\Gallery $gallery = null)
    {
        $this->gallery = $gallery;
        $this->gallery->addImage($this);
        return $this;
    }

    /**
     * Get gallery
     *
     * @return \Wn\GalleryBundle\Entity\Gallery 
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    public function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->gallery->getUploadDir();
    }

    public function setFile(UploadedFile $file)
    {
        $this->file = $file;

        if(null !== $this->url){
            $this->tempFilename = $this->url;
            $this->url = null;
            $this->alt = null;
        }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if(null === $this->file){
            return;
        }

        $this->url = $this->file->guessExtension();
        $this->alt = $this->file->getClientOriginalName();
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function Upload()
    {
        if(null === $this->file){
            return;
        }

        if(null !== $this->tempFilename){
            $oldFile = $this->getUploadRootDir().'/'.$this->getId().'.'.$this->tempFilename;
            if(file_exists($oldFile)){
                unlink($oldFile);
            }
        }

        $this->file->move(
            $this->getUploadRootDir(),
            $this->getId().'.'.$this->url
        );
    }

    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload()
    {
        $this->tempFilename = $this->getUploadRootDir().'/'.$this->getId().'.'.$this->url;
    }

    /**
     * @ORM\PostRemove()
     */
    public function RemoveUpload()
    {
        if(file_exists($this->tempFilename)){
            unlink($this->tempFilename);
        }
    }

    /**
     * Set url
     *
     * @param string $url
     * @return ImageGallery
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set alt
     *
     * @param string $alt
     * @return ImageGallery
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;
    
        return $this;
    }

    /**
     * Get alt
     *
     * @return string 
     */
    public function getAlt()
    {
        return $this->alt;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function getWebPath()
    {
        return $this->gallery->getUploadDir().'/'.$this->getId().'.'.$this->getUrl();
    }
}