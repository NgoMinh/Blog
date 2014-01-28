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
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $creationDate;

    /**
     * @var string
     * @ORM\Column(name="title", type="text")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="synopsis", type="text")
     */
    private $synopsis;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var boolean
     *
     * @ORM\Column(name="publish", type="boolean")
     */
    private $publish;

    /**
     * @ORM\OneToOne(targetEntity="Wn\BlogBundle\Entity\Poster", cascade={"persist","remove"})
     */
    private $poster;

    /**
     * @ORM\ManyToOne(targetEntity="Wn\BlogBundle\Entity\Category", inversedBy="articles")
     */
    private $category;

    public function __construct()
    {
        $this->creationDate = new \Datetime;
        $this->setDateOfPublication(new \Datetime);
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return Article
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    
        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime 
     */
    public function getCreationDate()
    {
        return $this->creationDate;
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
     * Set content
     *
     * @param string $content
     * @return Article
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set publish
     *
     * @param boolean $publish
     * @return Article
     */
    public function setPublish($publish)
    {
        $this->publish = $publish;
    
        return $this;
    }

    /**
     * Get publish
     *
     * @return boolean 
     */
    public function getPublish()
    {
        return $this->publish;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Article
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

    public function getPoster()
    {
        return $this->poster;
    }

    /**
     * Set poster
     *
     * @param \Wn\BlogBundle\Entity\Poster $poster
     * @return Article
     */
    public function setPoster(\Wn\BlogBundle\Entity\Poster $poster = null)
    {
        $this->poster = $poster;
    
        return $this;
    }

    /**
     * Set category
     *
     * @param \Wn\BlogBundle\Entity\Category $category
     * @return Article
     */
    public function setCategory(\Wn\BlogBundle\Entity\Category $category = null)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return \Wn\BlogBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
}