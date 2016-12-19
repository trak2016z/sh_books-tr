<?php

/*
 * The file represents Book class that contains all fields in Book form with their validations rules.
 * 
 * All rights reserved. © 2016 inż. Konrad Niżnik.
 */

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Book {
    
    /**
     * @Assert\Type("string")
     * @Assert\NotBlank()
     */
    public $name;
    
    /**
     * @Assert\Type("string")
     * @Assert\NotBlank()
     */
    public $author;
    
    /**
     * @Assert\Length(
     *      min = 5,
     *      max = 255)
     */
    public $description;
    
    public $forChange;
    
    /**
     * @Assert\Type("string")
     */
    public $keyWords;
    
    /**
     * @Assert\NotBlank()
     */
    public $category;
    
}
