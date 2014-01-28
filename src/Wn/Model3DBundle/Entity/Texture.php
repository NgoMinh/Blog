<?php

namespace Wn\Model3DBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Texture
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Wn\Model3DBundle\Entity\TextureRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Texture
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
     * @ORM\ManyToOne(targetEntity="Wn\Model3DBundle\Entity\Model3D", inversedBy="textures", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $model3D;

    private $file;
    private $tempFile;
    private $tempFilename;
    private $tempFileExtensionName;


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
     * Set model3D
     *
     * @param \Wn\Model3DBundle\Entity\Model3D $model3D
     * @return Texture
     */
    public function setModel3D(\Wn\Model3DBundle\Entity\Model3D $model3D)
    {
        $this->model3D = $model3D;
        $model3D->addTexture($this);
        return $this;
    }

    /**
     * Get model3D
     *
     * @return \Wn\Model3DBundle\Entity\Model3D 
     */
    public function getModel3D()
    {
        return $this->model3D;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
        if(null !== $this->fileName && null !== $this->fileExtension)
        {
            $this->tempFilename          = $this->fileName;
            $this->tempFileExtensionName = $this->Extension;
            $this->fileName              = null;
            $this->fileExtension         = null;
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

        if(null !== $this->tempFileExtensionName && null !== $this->tempFilename){
            $oldFile = $this->getUploadRootDir().'/'.$this->$tempFilename.'.'.$this->tempFileExtensionName;
            if(file_exists($oldFile)){
                unlink($oldFile);
            }
        }

        $this->file->move(
            $this->getUploadRootDir(),
            $this->fileName
        );
    }

    /**
     * @ORM\PreRemove()
     */
    public function PreRemoveUpload()
    {
        $this->tempFile = $this->getUploadRootDir().'/'.$this->getFileName().'.'.$this->getFileExtension();
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

    public function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->model3D->getUploadDir();
    } 

    public function getWebPath()
    {
        return $this->model3D->getUploadDir().'/'.$this->getFileName();
    }

    /**
     * Set fileName
     *
     * @param string $fileName
     * @return Texture
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
     * @return Texture
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