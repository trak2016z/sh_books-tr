<?php

namespace AppBundle\Repository;

use AppBundle\Entity\books;

class booksRepository extends \Doctrine\ORM\EntityRepository {
    
    /**
     * Returns the 10 most recently added books.
     */
    public function findLastBooks() {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            "SELECT b.id, b.name, b.author, b.price, b.description, b.forChange 
            FROM AppBundle:books b 
            WHERE b.addedAt is not NULL 
            ORDER BY b.addedAt DESC"
        )->setMaxResults(10);
        return $query->getResult();
    }
    
    /**
     * Returns books that match to the search criteria.
     */
    public function findBooks($category, $searchField) {
        $em = $this->getEntityManager();
        
        $parameters = array();
        $where = '';
        if ((int)$category != 0) {
            $where .= "AND b.categories = :category";
            $parameters['category'] = $category;
        } else if ($searchField != '0') {
            $where .= "AND (b.name LIKE '%$searchField%' OR b.author LIKE '%$searchField%' OR b.keyWords LIKE '%$searchField%')";
        }
        
        $query = $em->createQuery(
            "SELECT b.id, b.name, b.author, b.price, b.description, b.forChange 
            FROM AppBundle:books b 
            WHERE b.addedAt is not NULL $where 
            ORDER BY b.addedAt DESC"
        )->setParameters($parameters);
        return $query->getResult();
    }
    
    /**
     * Returns book with specyfic book id.
     */
    public function findById($bookId, $withCategory = FALSE) {
        if ($withCategory) {
            $additionalSelect = ', IDENTITY(b.categories) AS categoryId, b.keyWords';
            $join = '';
        } else {
            $additionalSelect = ', u.email, u.phone';
            $join = 'JOIN b.users u';
        }
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            "SELECT b.id, b.name, b.author, b.price, b.description, b.forChange $additionalSelect 
            FROM AppBundle:books b 
            $join 
            WHERE b.addedAt is not NULL AND b.id = :bookId"
        )->setParameter("bookId", $bookId);
        
        $result = $query->getResult();
        if (!empty($result)) {
            return $result[0];
        }
        return $result;
    }
        
    /*
     * Returns new book object needed to add advertisement.
     */
    public function makeBook($user) {
        $books = new books();
        $books->setUsers($user);
        
        $em = $this->getEntityManager();
        $em->persist($books);
        $em->flush();
        
        return $books->getId();
    }
    
    /*
     * Updates book data in database.
     */
    public function update($data, $bookId, $today) {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            "UPDATE AppBundle:books b 
            SET b.name = :name, b.author = :author, b.description = :description, b.forChange = :forChange, 
            b.keyWords = :keyWords, b.price = :price, b.categories = :categoryId, b.addedAt = :today 
            WHERE b.id = :bookId"
        )->setParameters(array(
            'bookId' => $bookId,
            'name' => $data->name,
            'author' => $data->author,
            'description' => $data->description,
            'forChange' => $data->forChange,
            'keyWords' => $data->keyWords,
            'price' => $data->price,
            'categoryId' => $data->category,           
            'today' => new \DateTime($today)            
        ));
        $query->execute();
    }
    
}
