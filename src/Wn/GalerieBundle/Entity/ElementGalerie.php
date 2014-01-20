<?php

namespace Wn\GalerieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Wn\BlogBundle\Entity\Element;
/**
 * ElementGalerie
 *
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Wn\GalerieBundle\Entity\ElementGalerieRepository")
 */
class ElementGalerie extends Element
{

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="string", length=255)
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity="Wn\GalerieBundle\Entity\Galerie", inversedBy="elements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $galerie;

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
        $this->setDatePublication(new \Datetime);
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return ElementGalerie
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

    /**
     * Set note
     *
     * @param string $note
     * @return ElementGalerie
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
     * Set galerie
     *
     * @param \Wn\GalerieBundle\Entity\Galerie $galerie
     * @return ElementGalerie
     */
    public function setGalerie(\Wn\GalerieBundle\Entity\Galerie $galerie = null)
    {
        $this->galerie = $galerie;
        $this->galerie->addElement($this);
        return $this;
    }

    /**
     * Get galerie
     *
     * @return \Wn\GalerieBundle\Entity\Galerie 
     */
    public function getGalerie()
    {
        return $this->galerie;
    }

    public function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->galerie->getUploadDir();
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
     * @return ElementGalerie
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
     * @return ElementGalerie
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
        return $this->galerie->getUploadDir().'/'.$this->getId().'.'.$this->getUrl();
    }
}