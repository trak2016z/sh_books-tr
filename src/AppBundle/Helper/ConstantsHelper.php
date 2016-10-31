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
    
    /*
     * USA date time format, the same like in database.
     */
    public static $usaDateTimeFormat = "Y-m-d H:i:s";
    
    /*
     * The session object, which contains many important informactions like user role.
     */
    public static $session;

    /*
     * Initialize values of some class variables.
     */
    public static function initialize($request) {
        self::$session = $request->getSession();
    }
        
}
