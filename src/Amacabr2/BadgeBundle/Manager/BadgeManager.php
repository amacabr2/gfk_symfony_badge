<?php

namespace Amacabr2\BadgeBundle\Manager;

use Amacabr2\BadgeBundle\Entity\BadgeUnlock;
use Amacabr2\BadgeBundle\Event\BadgeUnlockedEvent;
use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\NoResultException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class BadgeManager {

    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * BadgeManager constructor.
     * @param ObjectManager $manager
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(ObjectManager $manager, EventDispatcherInterface $dispatcher) {
        $this->em = $manager;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Vérifie si le badge existe pour cette action et l'occurrence d'action et l'ouvrir pour l'utilisateur
     * @param User $user
     * @param string $action
     * @param int $actionCount
     * @internal param int $userId
     */
    public function checkAndUnlock(User $user, string $action, int $actionCount) {

        try {

            // Vérifier si on a un badge qui correspond à action et actionCount
            $badge = $this->em->getRepository('BadgeBundle:Badge')->findWithUnlockForAction($user->getId(), $action, $actionCount);

            // Vérifier si l'utilisateur a déjà ce badge
            if ($badge->getUnlocks()->isEmpty()) {

                // Débloquer le badge pour l'utilisateur en question
                $unlock = new BadgeUnlock();
                $unlock->setBadge($badge);
                $unlock->setUser($user);
                $this->em->persist($unlock);
                $this->em->flush();

                // Emet un évènement pour informer l'application du déblocage de base
                $this->dispatcher->dispatch(BadgeUnlockedEvent::NAME, new BadgeUnlockedEvent($unlock));

            }

        } catch (NoResultException $e) {
            // On ne fait rien
        }

    }

    /**
     * Récupères les badges de l'utiulisateur courant
     * @param User $user
     * @return array
     */
    public function getBadgeFor(User $user): array {
        return $this->em->getRepository('BadgeBundle:Badge')->findUnlockedFor($user->getId());
    }

}