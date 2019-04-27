<?php
namespace JobApi;

use JobApi\Controller\Rest\TokenController;
use Zend\Mvc\Router\Http\Segment;

return array(
    'router' => [
        'routes' => [
           
        ],
    ],

    'controllers' => array(
        'factories' => array(

        ),

        'invokables' => array(
           
        ),
    ),
    'service_manager' => array(
        'factories' => array(

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
