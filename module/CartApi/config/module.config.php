<?php
namespace CartApi;

use Zend\Mvc\Router\Http\Segment;
use CartApi\Controller\CartController;
use CartApi\ServiceFactory\Controller\CartControllerFactory;
use CartApi\ServiceFactory\Model\CartTableFactory;
use CartApi\Model\CartTable;

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
