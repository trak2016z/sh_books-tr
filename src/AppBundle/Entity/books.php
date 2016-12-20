<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * books
 *
 * @ORM\Table(name="books")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\booksRepository")
 */
class books
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\OneToMany(targetEntity="images", mappedBy="books")
     */
    private $images;
    
    /**
     * @ORM\OneToMany(targetEntity="favorites", mappedBy="books")
     */
    private $favorites;

    public function __construct() {
        $this->images = new ArrayCollection();
        $this->favorites = new ArrayCollection();
    }
    
    /**
     * @ORM\ManyToOne(targetEntity="categories", inversedBy="books")
     * @ORM\JoinColumn(name="categoryId", referencedColumnName="id", nullable=true)
     */
    private $categories;
    
    /**
     * @ORM\ManyToOne(targetEntity="users", inversedBy="books")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    private $users;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255, nullable=true)
     */
    private $author;
    
    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", nullable=true)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var bool
     *
     * @ORM\Column(name="forChange", type="boolean", nullable=true)
     */
    private $forChange;

    /**
     * @var string
     *
     * @ORM\Column(name="keyWords", type="string", length=255, nullable=true)
     */
    private $keyWords;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="addedAt", type="date", nullable=true)
     */
    private $addedAt;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return books
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
     * Set author
     *
     * @param string $author
     *
     * @return books
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return books
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set forChange
     *
     * @param boolean $forChange
     *
     * @return books
     */
    public function setForChange($forChange)
    {
        $this->forChange = $forChange;

        return $this;
    }

    /**
     * Get forChange
     *
     * @return bool
     */
    public function getForChange()
    {
        return $this->forChange;
    }

    /**
     * Set keyWords
     *
     * @param string $keyWords
     *
     * @return books
     */
    public function setKeyWords($keyWords)
    {
        $this->keyWords = $keyWords;

        return $this;
    }

    /**
     * Get keyWords
     *
     * @return string
     */
    public function getKeyWords()
    {
        return $this->keyWords;
    }

    /**
     * Set addedAt
     *
     * @param \DateTime $addedAt
     *
     * @return books
     */
    public function setAddedAt($addedAt)
    {
        $this->addedAt = $addedAt;

        return $this;
    }

    /**
     * Get addedAt
     *
     * @return \DateTime
     */
    public function getAddedAt()
    {
        return $this->addedAt;
    }

    /**
     * Add image
     *
     * @param \AppBundle\Entity\images $image
     *
     * @return books
     */
    public function addImage(\AppBundle\Entity\images $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \AppBundle\Entity\images $image
     */
    public function removeImage(\AppBundle\Entity\images $image)
    {
        $this->images->removeElement($image);
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

    /**
     * Add favorite
     *
     * @param \AppBundle\Entity\favorites $favorite
     *
     * @return books
     */
    public function addFavorite(\AppBundle\Entity\favorites $favorite)
    {
        $this->favorites[] = $favorite;

        return $this;
    }

    /**
     * Remove favorite
     *
     * @param \AppBundle\Entity\favorites $favorite
     */
    public function removeFavorite(\AppBundle\Entity\favorites $favorite)
    {
        $this->favorites->removeElement($favorite);
    }

    /**
     * Get favorites
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFavorites()
    {
        return $this->favorites;
    }

    /**
     * Set categories
     *
     * @param \AppBundle\Entity\categories $categories
     *
     * @return books
     */
    public function setCategories(\AppBundle\Entity\categories $categories = null)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Get categories
     *
     * @return \AppBundle\Entity\categories
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set users
     *
     * @param \AppBundle\Entity\users $users
     *
     * @return books
     */
    public function setUsers(\AppBundle\Entity\users $users = null)
    {
        $this->users = $users;

        return $this;
    }

    /**
     * Get users
     *
     * @return \AppBundle\Entity\users
     */
    public function getUsers()
    {
        return $this->users;
    }


    /**
     * Set price
     *
     * @param float $price
     *
     * @return books
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }
}
