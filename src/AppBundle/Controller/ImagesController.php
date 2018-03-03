<?php
/**
 * Created by PhpStorm.
 * User: nenis
 * Date: 29/1/2018
 * Time: 23:10
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Images;


class ImagesController extends FOSRestController
{
    /**
     * @Rest\Get("/api/images")
     */
    public function getAction(){

        //tuve que comentariar en la linea 14 de app_dev.php

        $restresult = $this->getDoctrine()->getRepository('AppBundle:Images')->findAll();
        if($restresult === null){
            return new View("No existen imagenes",Response::HTTP_NOT_FOUND);
        }

        return new View($restresult,Response::HTTP_ACCEPTED);
    }

    /**
     * @Rest\Get("/api/images/{id}")
     */
    public function idAction($id){
       $singleresult = $this->getDoctrine()->getRepository('AppBundle:Images')->find($id);
       if($singleresult === null){
           return new View("No existe el usuario", Response::HTTP_NOT_FOUND);
       }
       return new View($singleresult, Response::HTTP_ACCEPTED);
    }

    /**
     * @Rest\Post("/api/images")
     */
    public function postAction(Request $request){
        $data = new Images;
        $titulo = $request->get('titulo');
        $descripcion = $request->get('descripcion');
        $thumbnail = $request->get('thumbnail');
        $img_link = $request->get('img_link');
        $userId = 1;

        if(empty($titulo) || empty($thumbnail)){
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }

        $data->setTitulo($titulo);
        $data->setDescripcion($descripcion);
        $data->setThumbnail($thumbnail);
        $data->setImgLink($img_link);
        $data->setUserId($userId);

        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();

        return new View("User Added Successfully", Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/api/images/{id}")
     */
    public function updateAction($id, Request $request){

        $titulo = $request->get('titulo');
        $descripcion = $request->get('descripcion');
        $thumbnail = $request->get('thumbnail');
        $img_link = $request->get('img_link');

        if(empty($titulo) || empty($thumbnail)){
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }

        $img = $this->getDoctrine()->getRepository('AppBundle:Images')->find($id);

        if($img === null){
            return new View("La imagen ya no se encuentra disponible", Response::HTTP_NOT_FOUND);
        }

        $img->setTitulo($titulo);
        $img->setDescripcion($descripcion);
        $img->setThumbnail($thumbnail);
        $img->setImgLink($img_link);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return new View("Los datos de la imagen fueron actualizados", Response::HTTP_CREATED);
    }

    /**
     * @Rest\Delete("/api/images/{id}")
     */
    public function deleteAction($id){
        $img = $this->getDoctrine()->getRepository('AppBundle:Images')->find($id);
        if($img === null){
            return new View("La imagen ya no se encuentra disponible", Response::HTTP_NOT_FOUND);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($img);
        $em->flush();

        return new View("la imagen fue eliminada", Response::HTTP_OK);
    }

}