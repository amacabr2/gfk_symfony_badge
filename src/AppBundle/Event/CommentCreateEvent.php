<?php

namespace AppBundle\Event;


use AppBundle\Entity\Comment;
use Symfony\Component\EventDispatcher\Event;

class CommentCreateEvent extends Event {

    /**
     * @var Comment
     */
    private $comment;

    const NAME = "app.comment_created";

    /**
     * CommentCreateEvent constructor.
     * @param Comment $comment
     */
    public function __construct(Comment $comment) {
        $this->comment = $comment;
    }

    /**
     * @return Comment
     */
    public function getComment(): Comment {
        return $this->comment;
    }


}