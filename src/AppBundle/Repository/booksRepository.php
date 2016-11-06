<?php

namespace AppBundle\Repository;

/**
 * booksRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class booksRepository extends \Doctrine\ORM\EntityRepository {
    
    /**
     * Returns the 10 most recently added books.
     */
    public function findLastBooks() {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            "SELECT b.id, b.name, b.author, b.price, b.description, b.forChange 
            FROM AppBundle:books b 
            ORDER BY b.addedAt DESC"
        )->setMaxResults(10);
        return $query->getResult();
    }
    
}
