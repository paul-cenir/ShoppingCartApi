<?php

namespace JobApi\ServiceFactory\Controller;

use JobApi\Controller\JobController;
use JobApi\Model\JobItemsTable;
use JobApi\Model\JobTable;
use JobApi\Service\JobService;
use Psr\Container\ContainerInterface;

class JobControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $container = $container->getServiceLocator(); // remove if zf3
        $JobTable = $container->get(JobTable::class);
        $JobItemsTable = $container->get(JobItemsTable::class);
        $JobService = $container->get(JobService::class);

        return new JobController($JobTable, $JobItemsTable, $JobService);
    }
}
