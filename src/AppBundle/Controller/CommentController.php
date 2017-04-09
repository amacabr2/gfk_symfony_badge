<?php
/**
 * Created by PhpStorm.
 * User: amacabr2
 * Date: 08/04/17
 * Time: 14:09
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends Controller {

    /**
     * Formulaire pour ajouter un commentaire
     * @Route("/create", name="comment_create")
     * @return Response
     */
    public function newCommentController(): Response {
        return $this->render('comment/newComment.html.twig');
    }

}