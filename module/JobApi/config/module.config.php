<?php
namespace JobApi;

use Zend\Mvc\Router\Http\Segment;
use JobApi\Controller\JobController;
use JobApi\ServiceFactory\Controller\JobControllerFactory;
use JobApi\ServiceFactory\Model\JobTableFactory;
use JobApi\ServiceFactory\Model\JobItemsTableFactory;
use JobApi\Model\JobTable;
use JobApi\Model\Job;
use JobApi\Model\JobItems;
use JobApi\Model\JobItemsTable;
use JobApi\Model\Shipment;
use JobApi\Model\ShipmentTable;
use JobApi\ServiceFactory\Model\ShipmentTableFactory;
use JobApi\Service\JobService;
use JobApi\ServiceFactory\Service\JobServiceFactory;
use JobApi\Service\ShipmentService;
use JobApi\ServiceFactory\Service\ShipmentServiceFactory;
use JobApi\Filter\JobFilter;

return array(
    'router' => [
        'routes' => [
            'job' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/job[/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => [
                        'controller' => JobController::class,
                    ],
                ],
            ],
        ],
    ],

    'controllers' => array(
        'factories' => array(
            JobController::class => JobControllerFactory::class,
        ),

        'invokables' => array(

        ),
    ),
    'service_manager' => array(
        'factories' => array(
            JobTable::class => JobTableFactory::class,
            JobItemsTable::class => JobItemsTableFactory::class,
            ShipmentTable::class => ShipmentTableFactory::class,
            JobService::class => JobServiceFactory::class,
            ShipmentService::class => ShipmentServiceFactory::class,
        ),
        'invokables' => array(
            JobFilter::class => JobFilter::class,
            Job::class => Job::class,
            Shipment::class => Shipment::class,
            JobItems::class => JobItems::class,
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);
