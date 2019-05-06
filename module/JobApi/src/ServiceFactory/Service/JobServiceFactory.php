<?php

namespace JobApi\ServiceFactory\Service;

use CustomerApi\Model\CustomersTable;
use JobApi\Filter\JobFilter;
use JobApi\Model\Job;
use JobApi\Model\JobItems;
use JobApi\Model\JobItemsTable;
use JobApi\Model\JobTable;
use JobApi\Service\JobService;
use ProductApi\Model\ProductsTable;
use CartApi\Model\CartTable;
use Psr\Container\ContainerInterface;

class JobServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $JobTable = $container->get(JobTable::class);
        $JobFilter = $container->get(JobFilter::class);
        $ProductsTable = $container->get(ProductsTable::class);
        $CustomersTable = $container->get(CustomersTable::class);
        $Job = $container->get(Job::class);
        $JobItems = $container->get(JobItems::class);
        $JobItemsTable = $container->get(JobItemsTable::class);
        $CartTable = $container->get(CartTable::class);

        return new JobService($JobTable, $JobFilter, $ProductsTable, $CustomersTable, $Job, $JobItems, $JobItemsTable, $CartTable);
    }
}
