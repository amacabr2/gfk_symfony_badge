<?php

namespace Amacabr2\BadgeBundle\Manager;

use Amacabr2\BadgeBundle\Entity\BadgeUnlock;
use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\NoResultException;

class BadgeManager {

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(ObjectManager $manager) {
        $this->em = $manager;
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
            }
        } catch (NoResultException $e) {
            // On ne fait rien
        }

        // Emetter un évènement pour informer l'application du déblocage de base

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