<?php

namespace AuthBundle\Security;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

/**
 * Class AuthExceptionHandler
 */
class AuthExceptionHandler
{
    /**
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();
        $content = json_decode($response->getContent(), true);

        if (isset($content['error']) && $content['error'] === 'invalid_grant') {
            $content['error_description'] = 'Invalid username and password combination or an account with this email does not exist. Please make sure you are inputting the correct information.';
            $response->setContent(json_encode($content));
        }
    }
}
