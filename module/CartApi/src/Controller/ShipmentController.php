<?php

namespace CartApi\Controller;

use JobApi\Service\JobService;
use CartApi\Service\ShipmentService;
use Zend\Debug\Debug;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class ShipmentController extends AbstractRestfulController
{
    //protected $eventIdentifier = 'SecuredController';

    private $JobService;
    private $ShipmentService;
    public function __construct(
        JobService $JobService,
        ShipmentService $ShipmentService
    ) {
        $this->JobService = $JobService;
        $this->ShipmentService = $ShipmentService;
    }

    public function create($data)
    {
        //need to move in http verb put
        $params = $this->params()->fromPost();
      
        return new JsonModel([  $this->ShipmentService->updateShippingInCart($params)]);
    }
    public function get($id)
    {
        return new JsonModel([45]);
    }

    public function getList()
    {
        return new JsonModel([]);
    }

    public function update($id, $data)
    {
        return new JsonModel([]);
    }

    public function delete($id)
    {
        return new JsonModel([]);
    }

}
