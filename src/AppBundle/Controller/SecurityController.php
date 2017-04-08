<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends Controller {

    /**
     * Formulaire de connection
     * @Route("/login", name="login")
     * @method ("GET")
     * @return Response
     */
    public function loginAction(): Response {
        return $this->render('security/login.html.twig');
    }

}