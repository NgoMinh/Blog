<?php

namespace Wn\Model3DBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Wn\BlogBundle\Entity\Element;

/**
 * Model3D
 *
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Wn\Model3DBundle\Entity\Model3DRepository")
 */
class Model3D extends Element
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="fileName", type="string", length=255)
     */
    private $fileName;

    /**
     * @var string
     *
     * @ORM\Column(name="fileExtension", type="string", length=255)
     */
    private $fileExtension;

    /**
     * @var integer
     *
     * @ORM\Column(name="camDistanceMin", type="integer")
     */
    private $camDistanceMin;

    /**
     * @var integer
     *
     * @ORM\Column(name="camDistanceMax", type="integer")
     */
    private $camDistanceMax;

    /**
     * @var integer
     *
     * @ORM\Column(name="camStartPositionX", type="integer")
     */
    private $camStartPositionX;

    /**
     * @var integer
     *
     * @ORM\Column(name="camPositionY", type="integer")
     */
    private $camStartPositionY;

    /**
     * @var integer
     *
     * @ORM\Column(name="camPositionZ", type="integer")
     */
    private $camStartPositionZ;

    private $file;
    private $tempFile;
    private $tempFilename;
    private $tempFileExtension;

    /**
     * @ORM\OneToMany(targetEntity="Wn\Model3DBundle\Entity\Texture", mappedBy="model3D" , cascade={"remove","persist"})
     */
    private $textures;

    public function __construct()
    {
        $this->setDatePublication(new \Datetime);
        $this->textures = new \Doctrine\Common\Collections\ArrayCollection();
        $this->camDistanceMax = 200;
        $this->camDistanceMin = 0;
        $this->camStartPositionX = 0;
        $this->camStartPositionY = 0;
        $this->camStartPositionZ = 0;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Model3DD
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

    public function getUploadDir()
    {
        return 'uploads/modele3D/'.$this->getId().'.'.$this->getFileExtension();
    }

    public function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
        if(null !== $this->fileName)
        {
            $this->tempFilename = $this->fileName;
            $this->tempFileExtension = $this->fileExtension;
            $this->fileName = null;
            $this->fileExtension = null;
        }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function PreUpload()
    {
        if(null === $this->file){
            return;
        }

        $this->fileExtension = $this->file->guessExtension();
        $this->fileName      = $this->file->getClientOriginalName();
        foreach ($this->textures as $texture) {
            $texture->setModel3D($this);
        }
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

        if(null !== $this->tempFilename && null!== $this->tempFileExtension){
            $oldFile = $this->getUploadRootDir().'/'.$this->tempFilename.'.'.$this->tempFileExtension;
            if(file_exists($oldFile)){
                unlink($oldFile);
            }
        }

        $this->file->move(
            $this->getUploadRootDir(),
            $this->getId().'.'.$this->fileExtension
        );
    }

    /**
     * @ORM\PreRemove()
     */
    public function PreremoveUpload()
    {
        $this->tempFile = $this->getUploadRootDir().'/'.$this->getId().'.'.$this->getFileExtension();
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if(file_exists($this->tempFile)){
            unlink($this->tempFile);
        }
    }

    public function getWebPath()
    {
        return $this->getUploadDir().'/'.$this->getId().'.'.$this->getFileExtension();
    }

    /**
     * Add textures
     *
     * @param \Wn\Model3DBundle\Entity\Texture $textures
     * @return Model3D
     */
    public function addTexture(\Wn\Model3DBundle\Entity\Texture $textures)
    {
        $this->textures[] = $textures;
    
        return $this;
    }

    /**
     * Remove textures
     *
     * @param \Wn\Model3DBundle\Entity\Texture $textures
     */
    public function removeTexture(\Wn\Model3DBundle\Entity\Texture $textures)
    {
        $this->textures->removeElement($textures);
    }

    /**
     * Get textures
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTextures()
    {
        return $this->textures;
    }

    /**
     * Set camDistanceMin
     *
     * @param integer $camDistanceMin
     * @return Model3D
     */
    public function setCamDistanceMin($camDistanceMin)
    {
        $this->camDistanceMin = $camDistanceMin;
    
        return $this;
    }

    /**
     * Get camDistanceMin
     *
     * @return integer 
     */
    public function getCamDistanceMin()
    {
        return $this->camDistanceMin;
    }

    /**
     * Set camDistanceMax
     *
     * @param integer $camDistanceMax
     * @return Model3D
     */
    public function setCamDistanceMax($camDistanceMax)
    {
        $this->camDistanceMax = $camDistanceMax;
    
        return $this;
    }

    /**
     * Get camDistanceMax
     *
     * @return integer 
     */
    public function getCamDistanceMax()
    {
        return $this->camDistanceMax;
    }

    /**
     * Set camStartPositionX
     *
     * @param integer $camStartPositionX
     * @return Model3D
     */
    public function setCamStartPositionX($camStartPositionX)
    {
        $this->camStartPositionX = $camStartPositionX;
    
        return $this;
    }

    /**
     * Get camStartPositionX
     *
     * @return integer 
     */
    public function getCamStartPositionX()
    {
        return $this->camStartPositionX;
    }

    /**
     * Set camStartPositionY
     *
     * @param integer $camStartPositionY
     * @return Model3D
     */
    public function setCamStartPositionY($camStartPositionY)
    {
        $this->camStartPositionY = $camStartPositionY;
    
        return $this;
    }

    /**
     * Get camStartPositionY
     *
     * @return integer 
     */
    public function getCamStartPositionY()
    {
        return $this->camStartPositionY;
    }

    /**
     * Set camStartPositionZ
     *
     * @param integer $camStartPositionZ
     * @return Model3D
     */
    public function setCamStartPositionZ($camStartPositionZ)
    {
        $this->camStartPositionZ = $camStartPositionZ;
    
        return $this;
    }

    /**
     * Get camStartPositionZ
     *
     * @return integer 
     */
    public function getCamStartPositionZ()
    {
        return $this->camStartPositionZ;
    }

    /**
     * Set fileName
     *
     * @param string $fileName
     * @return Model3D
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    
        return $this;
    }

    /**
     * Get fileName
     *
     * @return string 
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set fileExtension
     *
     * @param string $fileExtension
     * @return Model3D
     */
    public function setFileExtension($fileExtension)
    {
        $this->fileExtension = $fileExtension;
    
        return $this;
    }

    /**
     * Get fileExtension
     *
     * @return string 
     */
    public function getFileExtension()
    {
        return $this->fileExtension;
    }
}