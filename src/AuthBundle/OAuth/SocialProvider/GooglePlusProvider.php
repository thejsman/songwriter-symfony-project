<?php

namespace AuthBundle\OAuth\SocialProvider;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GooglePlusProvider.
 */
class GooglePlusProvider extends AbstractGuzzleSocialProvider
{
    /**
     * {@inheritdoc}
     */
    public function getSocialData(string $token): SocialData
    {
        $data = $this->request(Request::METHOD_GET, '/plus/v1/people/me', [
            'query' => [
                'access_token' => $token,
            ],
        ]);

        return new SocialData(
            $data['id'],
            $data['name']['familyName'],
            $data['name']['givenName'],
            isset($data['emails']) ? $data['emails'][0]['value'] : null,
            isset($data['image']) ? $data['image']['url'] : null
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getBaseUrl(): string
    {
        return 'https://www.googleapis.com';
    }

    /**
     * {@inheritdoc}
     */
    protected function isInvalidTokenResponse(array $body): bool
    {
        return (int) $body['error']['code'] === Response::HTTP_UNAUTHORIZED
            || (int) $body['error']['code'] === Response::HTTP_FORBIDDEN;
    }
}
