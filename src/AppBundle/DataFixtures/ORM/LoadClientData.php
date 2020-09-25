<?php

namespace AppBundle\DataFixtures\ORM;

use AuthBundle\Entity\Client;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * LoadClientData.
 */
class LoadClientData extends AbstractFixture
{
    const CLIENT_ID = "1cr3vnsmxcw08gs8ksss080oc8kkww8soowkoo0kow40owoogs";
    const CLIENT_SECRET = "543win53sksog8gwk8gccc04ko0wwgkkg40skk80kc48ok8wwg";

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $client = new Client();
        $client->setRandomId(static::CLIENT_ID);
        $client->setSecret(static::CLIENT_SECRET);
        $client->setAllowedGrantTypes(['client_credentials', 'token', 'refresh_token', 'password', 'urn:external:grant-type']);
        $client->setRedirectUris([]);

        $this->addReference('auth-client', $client);

        $manager->persist($client);
        $manager->flush();
    }
}
