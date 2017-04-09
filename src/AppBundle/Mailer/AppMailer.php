<?php

namespace AppBundle\Mailer;

use Amacabr2\BadgeBundle\Entity\Badge;
use AppBundle\Entity\User;
use Symfony\Component\Templating\EngineInterface;

class AppMailer {

    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var EngineInterface
     */
    private $template;

    /**
     * AppMailer constructor.
     * @param \Swift_Mailer $mailer
     * @param EngineInterface $template
     */
    public function __construct(\Swift_Mailer $mailer, EngineInterface $template) {
        $this->mailer = $mailer;
        $this->template = $template;
    }

    /**
     * Création d'un mail pour annoncer un nouveau badge
     * @param Badge $badge
     * @return int
     */
    public function badgeUnlocked(Badge $badge, User $user) {
        $message = \Swift_Message::newInstance()
            ->setSubject('Vous avez débloquez le badge' . $badge->getName())
            ->setTo($user->getEmail())
            ->setFrom('noreply@doe.fr')
            ->setBody($this->template->render('emails/badge.text.twig', array(
                'badge' => $badge,
                'user' => $user
            )));
        return $this->mailer->send($message);
    }

}