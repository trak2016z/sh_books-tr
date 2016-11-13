<?php

/*
 * The controller that controls book searching.
 * 
 * All rights reserved. © 2016 inż. Konrad Niżnik.
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Search;
use AppBundle\Form\SearchForm;
use AppBundle\Helper\ConstantsHelper;

class SearchController extends Controller {
    
    /**
     * Renders the home page view.
     * 
     * @Route("/", name="homepage")
     */
    public function homepageAction(Request $request) {
        ConstantsHelper::initialize($this->get('twig')->getExtension('core')); 
        $em = $this->getDoctrine()->getManager();
        $form = $this->_createSearchForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $searchArray = $this->_prepareSearchArray($form->getData());
            return $this->redirectToRoute('books', $searchArray);
        }
        $books = $em->getRepository('AppBundle:books')->findLastBooks();
        
        $booksIds = array_column($books, 'id');
        $bookImages = $em->getRepository('AppBundle:images')->findByBookIds($booksIds);
        $bookImageArray = [];
        foreach ($bookImages as $bookImage) {
            $bookImageArray[$bookImage['bookId']] = $bookImage['name'];
        }
        
        return $this->render('page/home.html.twig', array(
            'form' => $form->createView(),
            'books' => $books,
            'booksImage' => $bookImageArray
        )); 
    }
    	
    /**
     * Renders a list of searched books.
     * 
     * @Route("/books/{category}/{searchField}", name="books")
     */
    public function booksAction(Request $request, $category=0, $searchField=0) {
        ConstantsHelper::initialize($this->get('twig')->getExtension('core'));
        $parameters = $this->_prepareParameters($category, $searchField);
        $form = $this->_createSearchForm($parameters);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $searchArray = $this->_prepareSearchArray($form->getData());
            return $this->redirectToRoute('books', $searchArray);
        }
        $em = $this->getDoctrine()->getManager();
	$books = $em->getRepository('AppBundle:books')->findBooks($parameters['category'], $parameters['searchField']); 
        
        $bookImageArray = [];
        if(!empty($books)) {
            $booksIds = array_column($books, 'id');
            $bookImages = $em->getRepository('AppBundle:images')->findByBookIds($booksIds);
            foreach ($bookImages as $bookImage) {
                $bookImageArray[$bookImage['bookId']] = $bookImage['name'];
            }
        }
        
        $variables = array(
            'form' => $form->createView(),
            'books' => $books,
            'booksImage' => $bookImageArray,
            'searchField' => $parameters['searchField'],
        )  + $parameters;
        
        return $this->render('page/books.html.twig', $variables);
    }
    
    /**
     * Renders the book details view.
     * 
     * @Route("/book/{id}", name="bookDetails")
     */
    public function bookDetailsAction(Request $request, $id) {
        ConstantsHelper::initialize($this->get('twig')->getExtension('core'));
        $em = $this->getDoctrine()->getManager();
        $form = $this->_createSearchForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $searchArray = $this->_prepareSearchArray($form->getData());
            return $this->redirectToRoute('books', $searchArray);
        }
        $book = $em->getRepository('AppBundle:books')->findById($id)[0];
        $images = $em->getRepository('AppBundle:images')->findByBookId($book['id']);
        
        return $this->render('page/bookDetails.html.twig', array(
            'form' => $form->createView(),
            'book' => $book,
            'images' => $images
        )); 
    }
    
    /**
     * The function returns a parameters array that contains a parameters from url, 
     * but modified in some cases (often for security issues).
     */
    private function _prepareParameters($category, $searchField) {
        if (!is_numeric($category)) {
            $category = 0;
        }
        $parameters['category'] = $category;
        $parameters['searchField'] = str_replace("+", " ", $searchField);
        
        return $parameters;
    }
    
    /**
     * Returns a form for searching books (with filled fields from URL).
     */
    private function _createSearchForm($parameters = NULL) {
        $search = new Search();
        if($parameters) {
            $search->searchField = $parameters['searchField'];
        }
        $form = $this->createForm(SearchForm::class, $search);
        
        return $form;
    }
            
     /**
     * Returns search array with parameters that can be inserted in the URL. 
     * For example, " " can't be inserted to URL address, so it's transform to "+"
     */
    private function _prepareSearchArray($search) {
        $searchArray['category'] = '0';
        $searchArray['searchField'] = str_replace(" ", "+", $search->searchField);
                
        return $searchArray;
    }
        
}
