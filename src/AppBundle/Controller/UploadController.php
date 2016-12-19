<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\images;

class UploadController extends Controller {

  /**
   * @Route("/files/{bookId}", name="uploadImages", requirements={"bookId": "\d+"})
   */
  public function uploadImagesAction(Request $request, $bookId) {
    $em = $this->getDoctrine()->getManager();
    $files = $request->files->get("files");
    //Należałoby jeszcze sprawdzać czy na pewno rozszeżenie pliku się zgadza oraz czy jego wielkość nie jest zbyt duża 
    //(obecnie sprawdzane jest to tylko po stronie klienta)
    $uploadService = $this->container->get("Upload");
    $fileRepository = $em->getRepository("AppBundle:images")->findByBooks($bookId);
    $uploadService->setParam($fileRepository, $request->getBasePath().'/images/');
    
    $book = $em->getRepository("AppBundle:books")->find($bookId);
            
    $json = $uploadService->request($files, new images(), $book, 'deleteImages');

    return new JsonResponse($json);
  }

  /**
   * @Route("/delete/{id}", name="deleteImages", requirements={"id": "\d+"})
   */
  public function deteleImagesAction($id){
    $em = $this->getDoctrine()->getManager();
    $uploadServices = $this->container->get("Upload");
    
    $file = $em->find("AppBundle:images", $id);
    $json = $uploadServices->delete('images/', $file->getName()); //fizyczne usunięcie pliku z serwera
    
    $em->remove($file);
    $em->flush();
    return new JsonResponse($json);
  }
}

