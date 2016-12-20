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
use AppBundle\Helper\FormHelper;
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
        $search = FormHelper::createSearchEntity();
        $form = $this->createForm(\AppBundle\Form\SearchForm::class, $search);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $searchArray = FormHelper::prepareSearchArray($form->getData());
            return $this->redirectToRoute('books', $searchArray);
        }
        $books = $em->getRepository('AppBundle:books')->findLastBooks();
        
        $booksIds = array_column($books, 'id');
        $bookImages = $em->getRepository('AppBundle:images')->findByBookIds($booksIds);
        //tutaj powinno być tylko jedno zdjęcie z sequence 1 (trzeba poprawić upload zdjęć)
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
     * @Route("/books/{category}/{searchField}", name="books", requirements={"category": "\d+"})
     */
    public function booksAction(Request $request, $category=0, $searchField=0) {
        ConstantsHelper::initialize($this->get('twig')->getExtension('core'));
        $parameters = $this->_prepareParameters($category, $searchField);
        $search = FormHelper::createSearchEntity($parameters);
        $form = $this->createForm(\AppBundle\Form\SearchForm::class, $search);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $searchArray = FormHelper::prepareSearchArray($form->getData());
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
            'booksImage' => $bookImageArray
        );
        
        return $this->render('page/books.html.twig', $variables);
    }
    
    /**
     * Renders the book details view.
     * 
     * @Route("/book/{id}", name="bookDetails", requirements={"id": "\d+"})
     */
    public function bookDetailsAction(Request $request, $id) {
        ConstantsHelper::initialize($this->get('twig')->getExtension('core'));
        $em = $this->getDoctrine()->getManager();
        $search = FormHelper::createSearchEntity();
        $form = $this->createForm(\AppBundle\Form\SearchForm::class, $search);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $searchArray = FormHelper::prepareSearchArray($form->getData());
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
        $parameters['category'] = $category;
        $parameters['searchField'] = str_replace("+", " ", $searchField);
        
        return $parameters;
    }
         
}
