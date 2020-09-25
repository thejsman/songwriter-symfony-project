<?php

namespace AppBundle\Security;

use AppBundle\Entity\User;
use AppBundle\Service\Receipt\CheckReceiptExpires;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class UserChecker.
 */
class UserChecker extends \Symfony\Component\Security\Core\User\UserChecker
{
    /**
     * @var CheckReceiptExpires
     */
    protected $checkReceiptExpires;

    /**
     * UserChecker constructor.
     *
     * @param CheckReceiptExpires $checkReceiptExpires
     */
    public function __construct(CheckReceiptExpires $checkReceiptExpires)
    {
        $this->checkReceiptExpires = $checkReceiptExpires;
    }

    /**
     * {@inheritdoc}
     */
    public function checkPreAuth(UserInterface $user)
    {
        /** @var User $user */
        if ($user && $user->getPurchaseDate()->isExpired()) {
            $this->checkReceiptExpires->updateExpires($user);
        }

        parent::checkPreAuth($user);
    }
}
