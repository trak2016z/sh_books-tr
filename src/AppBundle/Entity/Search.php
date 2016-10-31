<?php

/*
 * The file represents Search class that contains all fields in search books form with their validations rules.
 * 
 * All rights reserved. © 2016 inż. Konrad Niżnik.
 */

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class Search {
    
    public $searchField;
    
    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload) {
    }
    
}
