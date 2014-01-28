<?php

namespace Wn\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Wn\BlogBundle\Entity\CommentRepository")
 */
class Comment
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
     * @ORM\ManyToOne(targetEntity="Wn\UserBundle\Entity\User", inversedBy="comments")
     */
    private $author;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var boolean
     *
     * @ORM\Column(name="censored", type="boolean")
     */
    private $censored;

    /**
     * @ORM\ManyToOne(targetEntity="Wn\BlogBundle\Entity\Element", inversedBy="comments")
     */
    private $element;

    public function __construct()
    {
        $this->date = new \Datetime;
        $this->censored = false;
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
     * Set date
     *
     * @param \DateTime $date
     * @return Comment
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Comment
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
     * Set censored
     *
     * @param boolean $censored
     * @return Comment
     */
    public function setCensored($censored)
    {
        $this->censored = $censored;
    
        return $this;
    }

    /**
     * Get censored
     *
     * @return boolean 
     */
    public function getCensored()
    {
        return $this->censored;
    }

    /**
     * Set author
     *
     * @param \Wn\UserBundle\Entity\User $author
     * @return Comment
     */
    public function setAuthor(\Wn\UserBundle\Entity\User $author = null)
    {
        $this->author = $author;
    
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

    /**
     * Set element
     *
     * @param \Wn\BlogBundle\Entity\Element $element
     * @return Comment
     */
    public function setElement(\Wn\BlogBundle\Entity\Element $element = null)
    {
        $this->element = $element;
        $element->addComment($this);
        return $this;
    }

    /**
     * Get element
     *
     * @return \Wn\BlogBundle\Entity\Element 
     */
    public function getElement()
    {
        return $this->element;
    }
}