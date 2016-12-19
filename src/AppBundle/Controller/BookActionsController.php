<?php

/*
 * The controller that controls book actions (like adding new books).
 * 
 * All rights reserved. © 2016 inż. Konrad Niżnik.
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Helper\FormHelper;
use AppBundle\Helper\ConstantsHelper;

class BookActionsController extends Controller {
    
    /**
     * Renders the book details view.
     * 
     * @Route("/add-book/{bookId}", name="addBook", requirements={"bookId": "\d+"})
     */
    public function addBookAction(Request $request, $bookId = NULL) {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }
        $em = $this->getDoctrine()->getManager();
        if (!$bookId) {
            return $this->redirectToRoute('addBook', array('bookId' => $em->getRepository('AppBundle:books')->makeBook($user)));
        }
        ConstantsHelper::initialize($this->get('twig')->getExtension('core'));
        $search = FormHelper::createSearchEntity();
        $form = $this->createForm(\AppBundle\Form\SearchForm::class, $search);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $searchArray = FormHelper::prepareSearchArray($form->getData());
            return $this->redirectToRoute('books', $searchArray);
        }
        
        $bookForm = $this->_createBookForm($em);
        $bookForm->handleRequest($request);
        if ($bookForm->isSubmitted() && $bookForm->isValid()) {
            $em->getRepository('AppBundle:books')->update($bookForm->getData(), $bookId, date(ConstantsHelper::$usaDateFormat));
            return $this->redirectToRoute('homepage');
        }
        
        return $this->render('page/addBook.html.twig', array(
            'form' => $form->createView(),
            'bookForm' => $bookForm->createView(),
            'bookId' => $bookId
        )); 
    }
    
    /*
     * Returns book form (to adding new books).
     */
    private function _createBookForm($em) {
        $categories = [];
        foreach ($em->getRepository('AppBundle:categories')->getAll() as $category) {
            $categories[$category['name']] = $category['id'];
        }
        return $this->createForm(\AppBundle\Form\BookForm::class, new \AppBundle\Entity\Book(), array('categories' => $categories));
    }
    
}
