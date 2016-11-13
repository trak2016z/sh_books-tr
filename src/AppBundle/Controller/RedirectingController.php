<?php

/*
 * The controller that redirect URLs with a trailing slash to the same URL without a trailing slash 
 * (for example /tour/1/ to /tour/1).
 * 
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class RedirectingController extends Controller {
    
    /**
     * @Route("/{url}", name="remove_trailing_slash", requirements={"url" = ".*\/$"}, methods={"GET"})
     */
    public function removeTrailingSlashAction(Request $request) {
        $pathInfo = $request->getPathInfo();
        $requestUri = $request->getRequestUri();
        $url = str_replace($pathInfo, rtrim($pathInfo, ' /'), $requestUri);
        return $this->redirect($url, 301);
    }
            
}
