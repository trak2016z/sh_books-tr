<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * favorites
 *
 * @ORM\Table(name="favorites")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\favoritesRepository")
 */
class favorites
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
     * @ORM\ManyToOne(targetEntity="books", inversedBy="favorites")
     * @ORM\JoinColumn(name="bookId", referencedColumnName="id")
     */
    private $books;
    
    /**
     * @ORM\ManyToOne(targetEntity="users", inversedBy="favorites")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    private $users;


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
     * Set books
     *
     * @param \AppBundle\Entity\books $books
     *
     * @return favorites
     */
    public function setBooks(\AppBundle\Entity\books $books = null)
    {
        $this->books = $books;

        return $this;
    }

    /**
     * Get books
     *
     * @return \AppBundle\Entity\books
     */
    public function getBooks()
    {
        return $this->books;
    }

    /**
     * Set users
     *
     * @param \AppBundle\Entity\users $users
     *
     * @return favorites
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
}
