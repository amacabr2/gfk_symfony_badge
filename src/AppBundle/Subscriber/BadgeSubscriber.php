<?php

namespace AppBundle\Subscriber;


use Amacabr2\BadgeBundle\Event\BadgeUnlockedEvent;
use Amacabr2\BadgeBundle\Manager\BadgeManager;
use AppBundle\Event\CommentCreateEvent;
use AppBundle\Mailer\AppMailer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BadgeSubscriber implements EventSubscriberInterface {

    /**
     * @var AppMailer
     */
    private $mailer;
    /**
     * @var ObjectManager
     */
    private $em;
    /**
     * @var BadgeManager
     */
    private $badgeManager;

    /**
     * BadgeSubscriber constructor.
     * @param AppMailer $mailer
     * @param ObjectManager $em
     * @param BadgeManager $badgeManager
     */
    public function __construct(AppMailer $mailer, ObjectManager $em, BadgeManager $badgeManager) {
        $this->mailer = $mailer;
        $this->em = $em;
        $this->badgeManager = $badgeManager;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents() {
        return [
            BadgeUnlockedEvent::NAME => 'onBadgeUnlock',
            CommentCreateEvent::NAME => 'onNewComment'
        ];
    }

    public function onBadgeUnlock(BadgeUnlockedEvent $event) {
       return $this->mailer->badgeUnlocked($event->getBadge(), $event->getUser());
    }

    public function onNewComment(CommentCreateEvent $event) {
        $user = $event->getComment()->getUser();
        $commentsCount = $this->em->getRepository('AppBundle:Comment')->countForUser($user->getId());
        $this->badgeManager->checkAndUnlock($user, 'comment', $commentsCount);
    }

}