<?php

/*
 * The helper class that stores variables which are used in the different controllers.
 * 
 * All rights reserved. © 2016 inż. Konrad Niżnik.
 */

namespace AppBundle\Helper;

class ConstantsHelper {
    
    /**
     * Date format used in php files.
     */
    public static $dateFormat = "d.m.Y";
	
    /**
     * Date format used in twig files.
     */
    public static $twigDateFormat = "dd.mm.yyyy";
    
    /*
     * USA date format, the same like in database.
     */
    public static $usaDateFormat = "Y-m-d";
            
}
