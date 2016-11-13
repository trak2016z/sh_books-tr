<?php

namespace AppBundle\Repository;

/**
 * imagesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class imagesRepository extends \Doctrine\ORM\EntityRepository {
    
    /*
     * Returns all images for given book ids.
     */
    public function findByBookIds($bookIds) {
        $em = $this->getEntityManager();
        $where = '';
        foreach ($bookIds as $bookId) {
            $where .= " OR i.books = $bookId";
        }
        $where = substr($where, 4);
        $query = $em->createQuery(
            "SELECT IDENTITY(i.books) AS bookId, i.name 
            FROM AppBundle:images i 
            WHERE ($where) AND i.sequence = 1"
        );
        return $query->getResult();        
    }
    
    /*
     * Returns all images for given book id.
     */
    public function findByBookId($bookId) {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            "SELECT i.name 
            FROM AppBundle:images i 
            WHERE i.books = :bookId 
            ORDER BY i.sequence"
        )->setParameter('bookId', $bookId);
        return $query->getResult();        
    }
    
}
