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
     * Renders the book add or edit form.
     * 
     * @Route("/add-edit-book/{bookId}", name="addEditBook", requirements={"bookId": "\d+"})
     */
    public function addEditBookAction(Request $request, $bookId = NULL) {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }
        $em = $this->getDoctrine()->getManager();
        if (!$bookId) {
            return $this->redirectToRoute('addEditBook', array('bookId' => $em->getRepository('AppBundle:books')->makeBook($user)));
        }
        ConstantsHelper::initialize($this->get('twig')->getExtension('core'));
        $search = FormHelper::createSearchEntity();
        $form = $this->createForm(\AppBundle\Form\SearchForm::class, $search);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $searchArray = FormHelper::prepareSearchArray($form->getData());
            return $this->redirectToRoute('books', $searchArray);
        }
        
        $bookForm = $this->_createBookForm($em, $bookId);
        $bookForm->handleRequest($request);
        if ($bookForm->isSubmitted() && $bookForm->isValid()) {
            $em->getRepository('AppBundle:books')->update($bookForm->getData(), $bookId, date(ConstantsHelper::$usaDateFormat));
            return $this->redirectToRoute('homepage');
        }
        
        return $this->render('page/addEditBook.html.twig', array(
            'form' => $form->createView(),
            'bookForm' => $bookForm->createView(),
            'bookId' => $bookId
        )); 
    }
    
    /*
     * Returns book form (to adding new books).
     */
    private function _createBookForm($em, $bookId) {
        $book = $em->getRepository('AppBundle:books')->findById($bookId, TRUE);
        $bookObject = new \AppBundle\Entity\Book();
        if (!empty($book)) {
            $bookObject->author = $book['author'];
            $bookObject->category = $book['categoryId'];
            $bookObject->description = $book['description'];
            $bookObject->forChange = $book['forChange'];
            $bookObject->keyWords = $book['keyWords'];
            $bookObject->name = $book['name'];
            $bookObject->price = $book['price'];
        }
        
        $categories = [];
        foreach ($em->getRepository('AppBundle:categories')->getAll() as $category) {
            $categories[$category['name']] = $category['id'];
        }
        return $this->createForm(\AppBundle\Form\BookForm::class, $bookObject, array('categories' => $categories));
    }
    
}
