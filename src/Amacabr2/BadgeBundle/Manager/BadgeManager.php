<?php

namespace Amacabr2\BadgeBundle\Manager;

class BadgeManager {

    /**
     * Vérifi si le badge existe pour cette action et l'occurrence d'action et l'ouvrir pour l'utilisateur
     * @param int $userId
     * @param string $action
     * @param int $actionCount
     */
    public function checkAndUnlock(int $userId, string $action, int $actionCount): void {

        // Vérifier si on a un badge qui correspond à action et actionCount

        // Vérifier si l'utilisateur a déjà ce badge

        // Débloquer le badge pour l'utilisateur en question

        // Emetter un évènement pour informer l'application du déblocage de base

    }

}