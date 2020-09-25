<?php

namespace AppBundle\Action\Folder;

use AppBundle\Entity\Folder;
use Requestum\ApiBundle\Action\BaseAction;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ListDeletedAction.
 */
class ListDeletedAction extends BaseAction
{
    /**
     * {@inheritdoc}
     */
    public function executeAction(Request $request)
    {
        $deletedAt = $request->get('deletedAt', (new \DateTime('-7 day'))->format('Y-m-d H:i:s'));

        $songs = $this->getDoctrine()
            ->getRepository(Folder::class)
            ->getDeletedFolders($this->getUser(), $deletedAt);

        return $this->handleResponse($songs);
    }
}
