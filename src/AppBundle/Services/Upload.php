<?php

namespace AppBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;


class Upload {

  protected $repository;
  protected $path;
  protected $container;
  protected $em;
  protected $savePath;

  public function __construct($imageDirectory, EntityManager $entityManager, ContainerInterface $container) {
    $this->em = $entityManager;
    $this->container = $container;
    $this->savePath = $imageDirectory;
  }

  public function setParam($repository, $path) {
    $this->path = $path;
    $this->repository = $repository;
  }

  public function request($files, $object, $book, $container_delete) {
    if ($files) {
      return $this->save($files, $object, $book, $container_delete);
    } else {
      return $this->getFiles($container_delete);
    }
  }

  public function save($files, $object, $book, $container_delete) {
    $response['files'] = array();
    if (is_array($files)) {
        $sequence = 0;
        foreach ($files as $file) {
            $sequence++;
            $filename = $this->processImage($file);
            $file = $object;

            $this->setObject($file, $filename, $sequence, $book);
            $this->em->persist($file);
            $this->em->flush();
            
            $f = array(
                'name' => $filename,
                'url' => $this->path . $filename,
                'thumbnailUrl' => $this->path . 'small-'.$file->getName(),
                'deleteUrl' => $this->deleteLink($file->getId(), $container_delete),
                'deleteType' => "GET",
                'id' => $file->getId()
            );
            array_push($response['files'], $f);
        }
    }
    return $response;
  }
  
  protected function setObject($file, $filename, $sequence, $book){
    $file->setName($filename);
    $file->setSequence($sequence);
    $file->setBooks($book);
  }
  
  public function getFiles($container_delete) {
    $files = $this->repository;
    $response['files'] = array();

    foreach ($files as $file) {
      $f = array(
          'name' => $file->getName(),
          'url' => $this->path . $file->getName(),
          'thumbnailUrl' => $this->path . 'small-'.$file->getName(),
          'deleteUrl' => $this->deleteLink($file->getId(), $container_delete),
          'deleteType' => "GET"
      );
      array_push($response['files'], $f);
    }
    return $response;
  }

  public function delete($path, $file) {
    $this->deleteFile($path . $file);
    $this->deleteFile($path . "small-$file");
    $response = array(
        $file => true
    );

    return $response;
  }

  protected function deleteLink($id, $name) {
    return $this->container->get('router')->generate($name, array('id' => $id));
  }

  /**
   * Usuwanie pliku
   * @param type $file
   */
  protected function deleteFile($file) {
    $file_path = $file;
    if (file_exists($file_path)) {
      unlink($file_path);
    }
  }

  /**
   * Generowanie miniaturki
   * @param type $filename
   * @param type $path
   * @param type $width
   * @param type $height
   */
  protected function imagesThumnb($filename, $width, $height) {
    $a = getimagesize($this->savePath . $filename);
    $image_type = $a[2];

    if (in_array($image_type, array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_BMP))) {
      $thumb = new \Imagick();
      $thumb->readImage($this->savePath . $filename);
      //$thumb->resizeImage($width,$height,\Imagick::FILTER_LANCZOS,1);
      $thumb->scaleimage($width, $height, true);
      $save = $this->savePath . "small-$filename";
      $thumb->writeImage($save);
      $thumb->clear();
      $thumb->destroy();
    }
  }

  /**
   * Zapis zdjęcia
   * @param type $uploaded_file
   * @param type $path
   * @return string
   */
  protected function processImage($uploaded_file) {
    $uploaded_file_info = pathinfo($uploaded_file->getClientOriginalName());
    $filename = md5(uniqid()).'.'.$uploaded_file_info['extension'];
    $uploaded_file->move($this->savePath, $filename);

    // Content type
    header('Content-Type: image/jpeg');

    // Get new dimensions
    list($width, $height) = getimagesize($this->savePath."/$filename");
    $new_width = 80;
    $new_height = 58;

    // Resample
    $image_p = imagecreatetruecolor($new_width, $new_height);
    $image = imagecreatefromjpeg($this->savePath."/$filename");
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    imagejpeg($image_p, $this->savePath."/small-$filename");
    
    return $filename;
  }

}