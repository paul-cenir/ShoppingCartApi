<?php
namespace CartApi;

use Zend\Mvc\Router\Http\Segment;
use CartApi\Controller\CartController;
use CartApi\Controller\CartItemController;
use CartApi\ServiceFactory\Controller\CartControllerFactory;
use CartApi\ServiceFactory\Controller\CartItemControllerFactory;
use CartApi\ServiceFactory\Model\CartTableFactory;
use CartApi\ServiceFactory\Model\CartItemsTableFactory;
use CartApi\Model\CartTable;
use CartApi\Model\Cart;
use CustomerApi\Model\Customers;
use CartApi\Model\CartItems;
use CartApi\Model\CartItemsTable;
use CartApi\Service\CartService;
use CartApi\Service\CartItemService;
use CartApi\ServiceFactory\Service\CartServiceFactory;
use CartApi\ServiceFactory\Service\CartItemServiceFactory;
use CartApi\Filter\CartFilter;
use CartApi\Filter\CartItemFilter;
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
            'cart-item' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/cart-item[/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => [
                        'controller' => CartItemController::class,
                    ],
                ],
            ],
        ],
    ],

    'controllers' => array(
        'factories' => array(
            CartController::class => CartControllerFactory::class,
            CartItemController::class => CartItemControllerFactory::class,
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
            CartItemService::class => CartItemServiceFactory::class,
            ShipmentService::class => ShipmentServiceFactory::class,
            ShipmentTable::class => ShipmentTableFactory::class,
        ),
        'invokables' => array(
            CartFilter::class => CartFilter::class,
            CartItemFilter::class => CartItemFilter::class,
            Cart::class => Cart::class,
            CartItems::class => CartItems::class,
            ShipmentFilter::class => ShipmentFilter::class,
            Shipment::class => Shipment::class,
            Customers::class => Customers::class,
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
