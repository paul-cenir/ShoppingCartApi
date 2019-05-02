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
        return new JsonModel([  $this->ShipmentService->updateShippingInCart($data)]);
    }
}
