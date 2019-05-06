<?php

namespace CartApi\Controller;

use CartApi\Service\ShipmentService;
use JobApi\Service\JobService;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class ShipmentController extends AbstractRestfulController
{
    protected $eventIdentifier = 'SecuredController';

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
        $shipment = $this->ShipmentService->updateShippingInCart($data);
        if (!$shipment['isValid']) {
            $this->getResponse()->setStatusCode(400);
            return new JsonModel(["validation_error_messages" => $shipment['data']]);
        } else {
            return new JsonModel($shipment);
        }
    }

    public function update($id, $data)
    {
        return new JsonModel([]);
    }

    public function get($id)
    {
        $shipment = $this->ShipmentService->getRatesPerShippingMethod($id);
        if (!$shipment['isValid']) {
            $this->getResponse()->setStatusCode(400);
            return new JsonModel(["validation_error_messages" => $shipment['data']]);
        } else {
            return new JsonModel($shipment);
        }
    }

}
