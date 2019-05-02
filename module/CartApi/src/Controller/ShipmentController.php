<?php

namespace CartApi\Controller;

use CartApi\Service\ShipmentService;
use JobApi\Service\JobService;
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
        return new JsonModel([$this->ShipmentService->updateShippingInCart($data)]);
    }

    public function update($id, $data)
    {
        return new JsonModel([]);
    }

}
