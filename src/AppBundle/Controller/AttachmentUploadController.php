<?php

namespace AppBundle\Controller;

use Oneup\UploaderBundle\Controller\BlueimpController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class AttachmentUploadController.
 */
class AttachmentUploadController extends BlueimpController
{
    /**
     * {@inheritdoc}
     */
    protected function createSupportedJsonResponse($data, $statusCode = 200)
    {
        $data = $this->container->get('serializer')->serialize($data, 'json');

        return new JsonResponse($data, JsonResponse::HTTP_OK, [], true);
    }
}
