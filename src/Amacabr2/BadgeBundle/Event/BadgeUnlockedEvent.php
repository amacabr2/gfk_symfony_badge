<?php

namespace Amacabr2\BadgeBundle\Event;

use Amacabr2\BadgeBundle\Entity\Badge;
use Amacabr2\BadgeBundle\Entity\BadgeUnlock;
use AppBundle\Entity\User;
use Symfony\Component\EventDispatcher\Event;

class BadgeUnlockedEvent extends Event {

    const NAME = 'badge.unlock';

    /**
     * @var BadgeUnlock
     */
    private $badgeUnlock;

    /**
     * BadgeUnlockedEvent constructor.
     * @param BadgeUnlock $badgeUnlock
     */
    public function __construct(BadgeUnlock $badgeUnlock) {
        $this->badgeUnlock = $badgeUnlock;
    }

    /**
     * @return BadgeUnlock
     */
    public function getBadgeUnlock(): BadgeUnlock {
        return $this->badgeUnlock;
    }

    public function getBadge(): Badge {
        return $this->badgeUnlock->getBadge();
    }

    /**
     * @return User
     */
    public function getUser(): User {
        return $this->badgeUnlock->getUser();
    }

}