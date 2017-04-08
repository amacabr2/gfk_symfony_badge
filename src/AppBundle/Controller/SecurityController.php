<?php
/**
 * Created by PhpStorm.
 * User: amacabr2
 * Date: 08/04/17
 * Time: 13:45
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends Controller {

    /**
     * @Route("/login", name="login")
     * @return Response
     */
    public function loginAction(): Response {
        return $this->render('security/login.html.twig');
    }

}