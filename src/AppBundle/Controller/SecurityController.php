<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Helper\ConstantsHelper;
use AppBundle\Entity\Search;
use AppBundle\Form\SearchForm;

class SecurityController extends Controller {
    
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request) {
        ConstantsHelper::initialize($this->get('twig')->getExtension('core')); 
        
        $authenticationUtils = $this->get('security.authentication_utils');
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        
        $search = new Search();
        $form = $this->createForm(SearchForm::class, $search);
                
        return $this->render('security/login.html.twig', array(
            'form' => $form->createView(),
            'last_username' => $lastUsername,
            'error' => $error,
            'language' => $request->getLocale()
        ));
    }
    
}
