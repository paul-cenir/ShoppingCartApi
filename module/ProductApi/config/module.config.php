<?php
namespace ProductApi;

use ProductApi\Controller\ProductController;
use ProductApi\Model\ProductsTable;
use ProductApi\ServiceFactory\Controller\ProductControllerFactory;
use ProductApi\ServiceFactory\Model\ProductsTableFactory;
use Zend\Mvc\Router\Http\Segment;

return array(
    'router' => [
        'routes' => [
            'product' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/product[/:id]',
                    'defaults' => [
                        'controller' => ProductController::class,
                    ],
                ],
            ],
        ],
    ],
    'controllers' => array(
        'factories' => array(
            ProductController::class => ProductControllerFactory::class,
        ),
        'invokables' => array(
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            ProductsTable::class => ProductsTableFactory::class,
        ),
        'invokables' => array(

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
