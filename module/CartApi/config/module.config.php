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
        ],
    ],

    'controllers' => array(
        'factories' => array(
            CartController::class => CartControllerFactory::class,
        ),

        'invokables' => array(

        ),
    ),
    'service_manager' => array(
        'factories' => array(
            CartTable::class => CartTableFactory::class,
            CartItemsTable::class => CartItemsTableFactory::class,
            CartService::class => CartServiceFactory::class,
        ),
        'invokables' => array(
            CartFilter::class => CartFilter::class,
            Cart::class => Cart::class,
            CartItems::class => CartItems::class,
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
