<?php

namespace AppBundle\Service\Receipt;

use AppBundle\Entity\User;
use Psr\Log\LoggerInterface;
use ReceiptValidator\iTunes\Validator as iTunesValidator;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class CheckReceipt.
 */
class CheckReceiptExpires
{
    /**
     * @var string
     */
    protected $sharedSecret;

    /**
     * @var RegistryInterface
     */
    protected $registry;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * CheckReceiptExpires constructor.
     *
     * @param string            $sharedSecret
     * @param RegistryInterface $registry
     * @param LoggerInterface   $logger
     */
    public function __construct(string $sharedSecret, RegistryInterface $registry, LoggerInterface $logger)
    {
        $this->sharedSecret = $sharedSecret;
        $this->registry = $registry;
        $this->logger = $logger;
    }

    /**
     * @param User $user
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateExpires(User $user)
    {
        try {
            $validator = new iTunesValidator(iTunesValidator::ENDPOINT_SANDBOX);

            $response = $validator
                ->setReceiptData($user->getPurchaseDate()->getReceiptData())
                ->setExcludeOldTransactions(true)
                ->setSharedSecret($this->sharedSecret)
                ->validate();

            if ($response->isValid()) {
                $lastReceipt = $response->getLatestReceiptInfo();
                if (isset($lastReceipt[0])) {
                    $user->getPurchaseDate()->setExpiresDate(\DateTime::createFromFormat('Y-m-d H:i:s', $lastReceipt[0]->getExpiresDate()->toDateTimeString()));
                    $this->registry->getManager()->persist($user);
                    $this->registry->getManager()->flush();
                }
            }
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }
    }
}
