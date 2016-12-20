<?php

/*
 * The helper class that creates different form entities.
 * 
 * All rights reserved. © 2016 inż. Konrad Niżnik.
 */

namespace AppBundle\Helper;

class FormHelper {
    
    /**
     * Returns an entity object which is need to create form for searching books.
     */
    public static function createSearchEntity($parameters = NULL) {
        $search = new \AppBundle\Entity\Search();
        if($parameters && ($parameters['searchField'] != '0')) {
            $search->searchField = $parameters['searchField'];
            
        }
        return $search;
    }
    
    /**
    * Returns search array with parameters that can be inserted in the URL. 
    * For example, " " can't be inserted to URL address, so it's transform to "+"
    */
   public static function prepareSearchArray($search) {
        $searchArray['category'] = '0';
        $searchArray['searchField'] = str_replace(" ", "+", $search->searchField);
                
        return $searchArray;
    }
    
}
