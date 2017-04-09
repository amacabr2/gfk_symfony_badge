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

        $authentificationUtils = $this->get('security.authentication_utils');
        $error = $authentificationUtils->getLastAuthenticationError();
        $lastUsername = $authentificationUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'error' => $error,
            'last_username' => $lastUsername
        ));

    }

}