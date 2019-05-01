<?php
namespace CartApi;

use Zend\Mvc\Router\Http\Segment;
use CartApi\Controller\CartController;
use CartApi\ServiceFactory\Controller\CartControllerFactory;
use CartApi\ServiceFactory\Model\CartTableFactory;
use CartApi\ServiceFactory\Model\CartItemsTableFactory;
use CartApi\Model\CartTable;
use CartApi\Model\Cart;
use CartApi\Model\CartItems;
use CartApi\Model\CartItemsTable;
use CartApi\Service\CartService;
use CartApi\ServiceFactory\Service\CartServiceFactory;
use CartApi\Filter\CartFilter;
use CartApi\Controller\ShipmentController;
use CartApi\ServiceFactory\Controller\ShipmentControllerFactory;
use CartApi\Model\Shipment;
use CartApi\Model\ShipmentTable;
use CartApi\ServiceFactory\Model\ShipmentTableFactory;
use CartApi\Service\ShipmentService;
use CartApi\ServiceFactory\Service\ShipmentServiceFactory;
use CartApi\Filter\ShipmentFilter;

return array(
    'router' => [
        'routes' => [
            'cart' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/cart[/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => [
                        'controller' => CartController::class,
                    ],
                ],
            ],
            'shipment' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/shipment[/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => [
                        'controller' => ShipmentController::class,
                    ],
                ],
            ],
        ],
    ],

    'controllers' => array(
        'factories' => array(
            CartController::class => CartControllerFactory::class,
            ShipmentController::class => ShipmentControllerFactory::class,
        ),

        'invokables' => array(
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            CartTable::class => CartTableFactory::class,
            CartItemsTable::class => CartItemsTableFactory::class,
            CartService::class => CartServiceFactory::class,
            ShipmentService::class => ShipmentServiceFactory::class,
            ShipmentTable::class => ShipmentTableFactory::class,
        ),
        'invokables' => array(
            CartFilter::class => CartFilter::class,
            Cart::class => Cart::class,
            CartItems::class => CartItems::class,
            ShipmentFilter::class => ShipmentFilter::class,
            Shipment::class => Shipment::class,
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
