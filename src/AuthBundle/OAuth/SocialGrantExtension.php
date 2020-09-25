<?php

namespace AuthBundle\OAuth;

use AppBundle\Entity\User;
use AuthBundle\OAuth\SocialProvider\Exception\InvalidAccessTokenException;
use AuthBundle\OAuth\SocialProvider\SocialProviderInterface;
use Doctrine\ORM\EntityManagerInterface;
use FOS\OAuthServerBundle\Storage\GrantExtensionInterface;
use OAuth2\Model\IOAuth2Client;
use OAuth2\OAuth2;
use OAuth2\OAuth2ServerException;
use Requestum\ApiBundle\Util\ErrorFactory;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class SocialGrantExtension.
 */
class SocialGrantExtension implements GrantExtensionInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @var ErrorFactory
     */
    protected $errorFactory;

    /**
     * @var PropertyAccessorInterface
     */
    protected $accessor;

    /**
     * @var SocialProviderInterface[]
     */
    protected $providers;

    /**
     * SocialGrantExtension constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface     $validator
     * @param ErrorFactory           $errorFactory
     * @param array                  $providers
     */
    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator, ErrorFactory $errorFactory, array $providers = [])
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->errorFactory = $errorFactory;
        $this->accessor = PropertyAccess::createPropertyAccessor();

        foreach ($providers as $name => $provider) {
            $this->addProvider($name, $provider);
        }
    }

    /**
     * @param string                  $name
     * @param SocialProviderInterface $provider
     */
    public function addProvider(string $name, SocialProviderInterface $provider): void
    {
        $this->providers[$name] = $provider;
    }

    /**
     * @param IOAuth2Client $client
     * @param array         $inputData
     * @param array         $authHeaders
     *
     * @return array|bool
     *
     * @throws OAuth2ServerException
     */
    public function checkGrantExtension(IOAuth2Client $client, array $inputData, array $authHeaders)
    {
        if (!isset($this->providers[$inputData['service']])) {
            throw new OAuth2ServerException(OAuth2::HTTP_BAD_REQUEST, 'unsupported_network');
        }

        try {
            $socialData = $this->providers[$inputData['service']]->getSocialData($inputData['token']);
        } catch (InvalidAccessTokenException $exception) {
            return false;
        }

        $repository = $this->entityManager->getRepository(User::class);

        /** @var User $user */
        if (!$user = $repository->findOneBy(['externalServiceId' => $socialData->id, 'externalService' => $inputData['service']])) {
            if ($user = $repository->findOneBy(['email' => $socialData->email, 'externalServiceId' => null, 'externalService' => null])) {
                $user
                    ->setExternalServiceId($socialData->id)
                    ->setExternalService($inputData['service']);

                $this->entityManager->flush();

                return ['data' => $user];
            }

            $user = (new User())
                ->setExternalServiceId($socialData->id)
                ->setExternalService($inputData['service'])
                ->setName(\sprintf('%s %s', $socialData->firstName, $socialData->lastName))
                ->setEmail($socialData->email);

            /** @var ConstraintViolation[] $constraints */
            $constraints = $this->validator->validate($user, null, ['Social']);

            if (\count($constraints)) {
                $errors = [];

                foreach ($constraints as $constraint) {
                    $this->accessor->setValue(
                        $errors,
                        \sprintf('[%s]', \str_replace('.', '][', $constraint->getPropertyPath())),
                        $this->errorFactory->createFromConstraintViolation($constraint)
                    );
                }

                throw new OAuth2ServerException(OAuth2::HTTP_BAD_REQUEST, 'unprocessable_user', $errors);
            }

            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }

        return ['data' => $user];
    }
}
