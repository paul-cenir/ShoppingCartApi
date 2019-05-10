<?php

namespace JobApi\Controller;

use JobApi\Model\JobItemsTable;
use JobApi\Model\JobTable;
use JobApi\Service\JobService;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class JobController extends AbstractRestfulController
{
    protected $eventIdentifier = 'SecuredController';
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
        $accessToken = $this->getRequest()->getHeader('Authorization');
        $jobDetails = $this->JobService->addJobAndUpdateStockQty($data, $accessToken);
        if (!$jobDetails['isValid']) {
            $this->getResponse()->setStatusCode(400);
            return new JsonModel(["validation_error_messages" => $jobDetails['data']]);
        } else {
            return new JsonModel([$jobDetails['data']]);
        }
    }

    public function get($id)
    {
        $job = $this->JobService->getJob($id);
        if (!$job['isValid']) {
            $this->getResponse()->setStatusCode(400);
            return new JsonModel(["validation_error_messages" => $job['data']]);
        } else {
            return new JsonModel($job);
        }
    }
}
