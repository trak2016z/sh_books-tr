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
        //Pobranie obiektu zalogowanego użytkownika
        $user = $this->getUser();
        //Jeżeli użytkownik nie jest zalogowany, to system przekierowuje go do formularza logowania
        if (!$user) {
            return $this->redirectToRoute('login');
        }
        //Pobranie obiektu entity manager - potrzebnego do wywoływania metod z plików znajdujących się w src/Appbundle/Repository
        //(metody, te wykonują operacje na bazie danych)
        $em = $this->getDoctrine()->getManager();
        //Jeżeli nie podano id książki w parametrze tej metody, to zostaje stworzone nowe id książki 
        //i metoda wywoływana jest ponownie z nowym id.
        if (!$bookId) {
            return $this->redirectToRoute('addEditBook', array('bookId' => $em->getRepository('AppBundle:books')->makeBook($user)));
        }
        //Inicjalizuje format daty oraz format liczb.
        ConstantsHelper::initialize($this->get('twig')->getExtension('core'));
        //Tworzy obiekt encji potrzebny do wygenerowania formularza wyszukiwania. 
        //Formularz wyszukiwania zawiera tylko jedno pole - pole wyszukiwania i w innych 
        //metodach jest ono wypełniane wpisanym wcześniej tekstem.
        $search = FormHelper::createSearchEntity();
        //Tworzy formularz wyszukiwania.
        $form = $this->createForm(\AppBundle\Form\SearchForm::class, $search);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //Gdy formularz wyszukiwania książki został wysłany (bez błędów walidacji), 
            //system wyświetla wyniki wyszukiwania (wypełniając pole wyszukiwania wpisanym tekstem, zapisanym w zmiennej $searchArray).
            $searchArray = FormHelper::prepareSearchArray($form->getData());
            return $this->redirectToRoute('books', $searchArray);
        }
        //Tworzy formularz dodawania książki, wypełnianiąc, go wartościami zapisanymi w bazie danych - (przydaje się w edycji ogłoszenia),
        //jeśli w bazie danych nie ma informacji na temat danej książki (nie ma gdy książka jest dodawana), tworzony jest pusty formularz.
        $bookForm = $this->_createBookForm($em, $bookId);
        $bookForm->handleRequest($request);
        if ($bookForm->isSubmitted() && $bookForm->isValid()) {
            //Gdy formularz dodawania książki został wysłany (bez błędów walidacji), 
            //informacje wprowadzone w formularzu zostają zapisane w bazie danych
            $em->getRepository('AppBundle:books')->update($bookForm->getData(), $bookId, date(ConstantsHelper::$usaDateFormat));
            //Następuje przekierowanie do strony głównej
            return $this->redirectToRoute('homepage');
        }
        //Generuje widok ekranu z formularzem dodawania książki 
        //(w przyszłości plik addEditBook.html.twig planuje wykorzystywać również do generowania widoku edycji książki - stąd nazwa pliku)
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
