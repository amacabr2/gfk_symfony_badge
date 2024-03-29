<?php
/**
 * Created by PhpStorm.
 * User: amacabr2
 * Date: 08/04/17
 * Time: 14:09
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Comment;
use AppBundle\Event\CommentCreateEvent;
use AppBundle\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends Controller {

    /**
     * Formulaire pour ajouter un commentaire
     * @Route("/create", name="comment_create")
     * @param Request $request
     * @return Response
     */
    public function newCommentController(Request $request): Response {

        $em = $this->getDoctrine()->getManager();
        $comment = new Comment();
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $comment->setUser($user);
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $em->persist($comment);
            $em->getConnection()->beginTransaction();
            $em->flush();
            $this->get('event_dispatcher')->dispatch(CommentCreateEvent::NAME, new CommentCreateEvent($comment));
            $em->getConnection()->commit();
        }

        $comments = $em->getRepository('AppBundle:Comment')->findAll();
        $badges = $this->get('badge.manager')->getBadgeFor($user);

        return $this->render('comment/newComment.html.twig', array(
            'comments' => $comments,
            'form' => $form->createView(),
            'badges' => $badges
        ));

    }

}