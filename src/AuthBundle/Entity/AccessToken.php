<?php

namespace AuthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation as Serializer;

use FOS\OAuthServerBundle\Entity\AccessToken as BaseAccessToken;

/**
 * @ORM\Entity(repositoryClass="AuthBundle\Repository\AccessTokenRepository")
 */
class AccessToken extends BaseAccessToken
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Client", cascade={"persist"})
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     */
    protected $client;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     * @Serializer\Groups({"default"})
     */
    protected $user;
}