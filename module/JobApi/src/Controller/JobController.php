<?php

namespace JobApi\Controller;

use JobApi\Model\JobItemsTable;
use JobApi\Model\JobTable;
use JobApi\Service\JobService;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class JobController extends AbstractRestfulController
{
    //protected $eventIdentifier = 'SecuredController';

    private $JobTable;
    private $JobItemsTable;
    private $JobService;
    public function __construct(
        JobTable $JobTable,
        JobItemsTable $JobItemsTable,
        JobService $JobService
    ) {

        $this->JobTable = $JobTable;
        $this->JobItemsTable = $JobItemsTable;
        $this->JobService = $JobService;
    }

    public function create($data)
    {
        $params = $this->params()->fromPost();
        $jobDetails = $this->JobService->addJob($params);
        if ($jobDetails['isValid']) {
            return new JsonModel([$jobDetails['data']]);
        } else {
            $this->getResponse()->setStatusCode(400);
            return new JsonModel(["validation_error_messages" => $jobDetails['data']]);
        }
    }

}
