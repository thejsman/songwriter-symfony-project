<?php

namespace AuthBundle\OAuth\SocialProvider;

/**
 * Class SocialData.
 */
class SocialData
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $firstName;

    /**
     * @var string
     */
    public $lastName;

    /**
     * @var string|null
     */
    public $email;

    /**
     * @var string|null
     */
    public $avatar;

    /**
     * SocialData constructor.
     *
     * @param string      $id
     * @param string      $firstName
     * @param string      $lastName
     * @param string|null $email
     * @param string|null $avatar
     */
    public function __construct(string $id, string $firstName, string $lastName, string $email = null, string $avatar = null)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->avatar = $avatar;
    }
}
