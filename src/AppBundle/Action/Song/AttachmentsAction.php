<?php

namespace AppBundle\Action\Song;

use AppBundle\Entity\File;
use Requestum\ApiBundle\Action\BaseAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class AttachmentsAction.
 */
class AttachmentsAction extends BaseAction
{
    /**
     * {@inheritdoc}
     */
    public function executeAction(Request $request)
    {
        if (null === $path = $request->get('path')) {
            throw new BadRequestHttpException(sprintf('Parameter "path" is required, "%s" given.'));
        }

        /** @var File $file */
        $file = $this->getDoctrine()
            ->getRepository(File::class)
            ->findOneBy(['path' => $path]);

        if (null === $file) {
            throw new NotFoundHttpException(sprintf('Object with path "%s" not found.', $path));
        }

        if (!$content = $this->get('oneup_flysystem.attachments_filesystem')->read($file->getPath())) {
            throw new NotFoundHttpException(sprintf('Object with path "%s" not found.', $file->getPath()));
        }

        $response = new Response($content);

        $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $file->getName());

        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }
}
