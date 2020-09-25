<?php

namespace AuthBundle\OAuth\SocialProvider;

use AuthBundle\OAuth\SocialProvider\Exception\InvalidAccessTokenException;
use AuthBundle\OAuth\SocialProvider\Exception\SocialException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 * Class AbstractGuzzleSocialProvider
 */
abstract class AbstractGuzzleSocialProvider implements SocialProviderInterface
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * AbstractGuzzleSocialProvider constructor.
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->getBaseUrl(),
        ]);
    }

    /**
     * @return string
     */
    abstract protected function getBaseUrl(): string;

    /**
     * @param array $body
     *
     * @return bool
     */
    abstract protected function isInvalidTokenResponse(array $body): bool;

    /**
     * @param string $method
     * @param string $url
     * @param array  $params
     *
     * @return array
     */
    protected function request(string $method, string $url, array $params = []): array
    {
        try {
            $data = $this->client->request($method, $url, $params)->getBody()->getContents();
        } catch (ClientException $exception) {
            $body = \json_decode($exception->getResponse()->getBody()->getContents(), true);

            if ($this->isInvalidTokenResponse($body)) {
                throw new InvalidAccessTokenException('', 0, $exception);
            }

            throw new SocialException('', 0, $exception);
        }

        return \json_decode($data, true);
    }
}
