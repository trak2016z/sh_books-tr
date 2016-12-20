<?php

/*
 * The file represents Book class that contains all fields in Book form with their validations rules.
 * 
 * All rights reserved. © 2016 inż. Konrad Niżnik.
 */

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

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
    
    /**
     * @Assert\Type("string")
     * @Assert\NotBlank()
     */
    public $price;
    
    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload) {
        if (!preg_match('/^[0-9]+(\,[0-9]{2})?$/', $this->price)) {
            $context->buildViolation('Cena musi być w formacie "100" lub "100,00."')
                ->atPath('price')
                ->addViolation();
        }
    }
    
}
