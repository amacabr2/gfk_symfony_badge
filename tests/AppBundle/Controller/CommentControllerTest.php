<?php

namespace Tests\AppBundle\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class CommentControllerTest extends WebTestCase {

    /**
     * Test si les personnes non autorisées n'accèdent pas au reste du site
     */
    public function testUnauthorized() {
        $client = $this->makeClient();
        $client->request('GET', '/create');
        $this->assertStatusCode('302', $client);
    }

}