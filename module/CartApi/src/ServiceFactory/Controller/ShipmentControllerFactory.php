<?php

namespace CartApi\ServiceFactory\Controller;

use CartApi\Controller\ShipmentController;
use CartApi\Service\ShipmentService;
use JobApi\Service\JobService;
use Psr\Container\ContainerInterface;

class ShipmentControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $container = $container->getServiceLocator(); // remove if zf3
        $JobService = $container->get(JobService::class);
        $ShipmentService = $container->get(ShipmentService::class);

        return new ShipmentController($JobService, $ShipmentService);
    }
}
