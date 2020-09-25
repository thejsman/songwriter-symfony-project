<?php

namespace AuthBundle\OAuth\SocialProvider;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class FacebookProvider.
 */
class FacebookProvider extends AbstractGuzzleSocialProvider
{
    /**
     * {@inheritdoc}
     */
    public function getSocialData(string $token): SocialData
    {
        $data = $this->request(Request::METHOD_GET, '/me', [
            'query' => [
                'fields' => 'email,first_name,last_name,id,picture.type(large)',
                'access_token' => $token,
            ],
        ]);

        return new SocialData(
            $data['id'],
            $data['first_name'],
            $data['last_name'],
            isset($data['email']) ? $data['email'] : null,
            isset($data['picture']) ? $data['picture']['data']['url'] : null
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getBaseUrl(): string
    {
        return 'https://graph.facebook.com';
    }

    /**
     * {@inheritdoc}
     */
    protected function isInvalidTokenResponse(array $body): bool
    {
        return isset($body['error']['code']) && 190 === (int) $body['error']['code'];
    }
}
