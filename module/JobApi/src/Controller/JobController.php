<?php

namespace JobApi\Controller;

use JobApi\Model\JobItemsTable;
use JobApi\Model\JobTable;
use JobApi\Service\JobService;
use JobApi\Service\ShipmentService;
use Zend\Debug\Debug;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class JobController extends AbstractRestfulController
{
    //protected $eventIdentifier = 'SecuredController';

    private $JobTable;
    private $JobItemsTable;
    private $JobService;
    private $ShipmentService;
    public function __construct(
        JobTable $JobTable,
        JobItemsTable $JobItemsTable,
        JobService $JobService,
        ShipmentService $ShipmentService
    ) {

        $this->JobTable = $JobTable;
        $this->JobItemsTable = $JobItemsTable;
        $this->JobService = $JobService;
        $this->ShipmentService = $ShipmentService;
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

    public function get($id)
    {
        return new JsonModel([]);
    }

    public function getList()
    {
        return new JsonModel([$this->ShipmentService->computeShippingTotal()]);
    }

    public function update($id, $data)
    {

        \Zend\Debug\Debug::dump('update');
        exit;
    }

    public function delete($id)
    {
        \Zend\Debug\Debug::dump('delete');
        exit;
    }

}
