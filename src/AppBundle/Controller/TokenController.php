<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Usuarios;


class TokenController extends Controller
{
    /**
     * @Route("/api/tokens")
     * @Method("POST")
     */
    public function newTokenAction(Request $request){
        $user = $this->getDoctrine()
            ->getRepository('AppBundle:Usuarios')
            ->findOneBy(array('name' => $request->get('name'), 'pass' => $request->get('pass')));

        if (!$user){
            //throw $this->createNotFoundException();
            //$token = $request->getContent().key(['name', 'pass']);
            //throw new BadCredentialsException("Usuario o Contraseña incorectos");
        }
        else{
            $token = $this->get('lexik_jwt_authentication.encoder')
                ->encode([
                    'username' => $request->get('name'),
                    'exp' => time() + 3600
                ]);
        }

        /*$isValid = $this->get('security.password_encoder')
            ->isPasswordValid($user, $request->get('pass'));

        if(!$isValid){
            throw new BadCredentialsException();
        }*/


        return new JsonResponse(['token' => $token]);
    }
}
