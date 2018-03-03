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
use AppBundle\Entity\User;


class UserController extends FOSRestController
{
    /**
     * @Rest\Get("/api/users")
     */
    public function getAction(){

        $em = $this->getDoctrine()->getManager();
        $r = $em->createQuery('SELECT us.id FROM AppBundle:User us')->getArrayResult();
        return new View($r,Response::HTTP_ACCEPTED);
        //tuve que comentariar en la linea 14 y la 19 de app_dev.php



        /*$restresult = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
        //$restresult = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
        if($restresult === null){
            return new View("No existen usuarios",Response::HTTP_NOT_FOUND);
        }
        return new View($restresult,Response::HTTP_ACCEPTED);*/
    }

}