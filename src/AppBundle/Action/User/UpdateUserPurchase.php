<?php

namespace AppBundle\Action\User;

use Requestum\ApiBundle\Action\UpdateAction;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UpdateUserPurchase.
 */
class UpdateUserPurchase extends UpdateAction
{
    /**
     * {@inheritdoc}
     */
    protected function provideEntity(Request $request)
    {
        return $this->getEntity($request, null, $this->options['use_lock'])->getUser();
    }
}
