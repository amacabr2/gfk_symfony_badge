<?php

namespace Tests\AppBundle\Controller;

use AppBundle\DataFixtures\ORM\LoadUserData;
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

    /**
     * Permet de vérifier si on peut poster un commentaire
     */
    public function testPostComment() {

        $em = $this->getContainer()->get('doctrine')->getManager();

        $references = $this->loadFixtures([LoadUserData::class])->getReferenceRepository();
        $user = $references->getReference('user');
        $this->loginAs($user, 'main');
        $client = $this->makeClient();
        $crawler = $client->request('GET', '/create');
        $this->assertStatusCode('200', $client);

        //Poste un commentaire
        $form = $crawler->selectButton('Commenter')->form();
        $form->setValues(array(
           'appbundle_comment[content]' => 'Salut les gens ! '
        ));
        $client->submit($form);
        $this->assertStatusCode('200', $client);
        $this->assertCount(1, $em->getRepository('AppBundle:Comment')->findAll());

    }

}