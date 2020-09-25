<?php

namespace AuthBundle\OAuth\SocialProvider;

/**
 * Interface SocialProviderInterface.
 */
interface SocialProviderInterface
{
    /**
     * @param string $token
     *
     * @return SocialData
     */
    public function getSocialData(string $token): SocialData;
}
