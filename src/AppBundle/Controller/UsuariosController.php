<?php
/**
 * Created by PhpStorm.
 * User: nenis
 * Date: 2/2/2018
 * Time: 22:50
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Usuarios;


class UsuariosController extends FOSRestController
{
    /**
 * @Rest\Get("/api/usuarios")
 */
    public function getAction(){

        /*$em = $this->getDoctrine()->getManager();
        $r = $em->createQuery('SELECT us.id FROM AppBundle:Image us')->getArrayResult();
        return new View($r,Response::HTTP_ACCEPTED);*/

        $restresult = $this->getDoctrine()->getRepository('AppBundle:Usuarios')->findAll();

        if($restresult === null){
            return new View("No existen usuarios",Response::HTTP_NOT_FOUND);
        }
        return new View($restresult,Response::HTTP_ACCEPTED);
    }

    /**
     * @Rest\Post("/api/login")
     */
    public function loginAction(Request $request){

        //$restresult = $this->getDoctrine()->getRepository('AppBundle:Usuarios')->findAll();

        $restresult = null;
        $user_name = $request->get('name');
        $user_pass = $request->get('pass');
        $r = $this->getDoctrine()->getRepository('AppBundle:Usuarios')->findBy(array('name' => $user_name, 'pass' => $user_pass));

        if($r)
        {
            $restresult = "Login OK ". base64_encode($user_name.$user_pass);


        }
        else
            $restresult = "Revise su Usuario y Contraseña";


        /*
        if($restresult === null){
            return new View("No existen usuarios",Response::HTTP_NOT_FOUND);
        }*/

        return new View($restresult,Response::HTTP_ACCEPTED);
    }
}