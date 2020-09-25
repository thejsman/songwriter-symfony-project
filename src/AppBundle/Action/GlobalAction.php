<?php

namespace AppBundle\Action;

use Requestum\ApiBundle\Action\ActionInterface;
use Requestum\ApiBundle\Action\BaseAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GlobalAction
 */
class GlobalAction extends BaseAction
{
    /**
     * @var ActionInterface
     */
    private $createService;

    /**
     * @var ActionInterface
     */
    private $updateService;

    /**
     * GlobalAction constructor.
     *
     * @param ActionInterface $createService
     * @param ActionInterface $updateService
     */
    public function __construct(ActionInterface $createService, ActionInterface $updateService)
    {
        parent::__construct();

        $this->createService = $createService;
        $this->updateService = $updateService;
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse|Response
     *
     * @throws \Exception
     */
    public function executeAction(Request $request)
    {
        if (-1 !== $id = (int) $request->get('id', -1)) {
            return $this->updateService->executeAction($request);
        }

        return $this->createService->executeAction($request);
    }
}
