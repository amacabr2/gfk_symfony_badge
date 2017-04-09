<?php

namespace Amacabr2\BadgeBundle\Entity;

use AppBundle\AppBundle;
use Doctrine\ORM\Mapping as ORM;

/**
 * BadgeUnlock
 *
 * @ORM\Table(name="badge_unlock")
 * @ORM\Entity(repositoryClass="Amacabr2\BadgeBundle\Repository\BadgeUnlockRepository")
 */
class BadgeUnlock
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Badge
     *
     * @ORM\ManyToOne(targetEntity="Amacabr2\BadgeBundle\Entity\Badge", inversedBy="unlocks")
     */
    private $badge;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $user;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set badge
     *
     * @param \Amacabr2\BadgeBundle\Entity\Badge $badge
     *
     * @return BadgeUnlock
     */
    public function setBadge(\Amacabr2\BadgeBundle\Entity\Badge $badge = null) {
        $this->badge = $badge;

        return $this;
    }

    /**
     * Get badge
     *
     * @return \Amacabr2\BadgeBundle\Entity\Badge
     */
    public function getBadge() {
        return $this->badge;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\Badge $user
     *
     * @return BadgeUnlock
     */
    public function setUser(\AppBundle\Entity\Badge $user = null) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser() {
        return $this->user;
    }
}
