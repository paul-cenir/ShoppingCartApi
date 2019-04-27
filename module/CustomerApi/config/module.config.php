<?php
namespace CustomerApi;

use CustomerApi\Controller\LoginController;
use CustomerApi\Controller\Registration\RegistrationController;
use CustomerApi\Controller\Rest\TokenController;
use CustomerApi\Filter\Login\LoginFilter;
use CustomerApi\Filter\Registration\RegistrationFilter;
use CustomerApi\Model\Customers;
use CustomerApi\Model\CustomersTable;
use CustomerApi\ServiceFactory\Controller\Login\LoginControllerFactory;
use CustomerApi\ServiceFactory\Controller\Registration\RegistrationControllerFactory;
use CustomerApi\ServiceFactory\Model\CustomersTableFactory;
use CustomerApi\ServiceFactory\Service\TokenServiceFactory;
use CustomerApi\ServiceFactory\Service\Login\LoginServiceFactory;
use CustomerApi\ServiceFactory\Service\Registration\RegistrationServiceFactory;
use CustomerApi\Service\TokenService;
use CustomerApi\Service\Login\LoginService;
use CustomerApi\Service\Registration\RegistrationService;
use Zend\Mvc\Router\Http\Segment;

return array(
    'router' => [
        'routes' => [
            'registration' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/registration[/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => [
                        'controller' => RegistrationController::class,
                    ],
                ],
            ],
            'login' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/login[/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => [
                        'controller' => LoginController::class,
                    ],
                ],
            ],

        ],
    ],

    'controllers' => array(
        'factories' => array(
            RegistrationController::class => RegistrationControllerFactory::class,
            LoginController::class => LoginControllerFactory::class,
        ),

        'invokables' => array(
            TokenController::class => TokenController::class,

        ),
    ),
    'service_manager' => array(
        'factories' => array(
            CustomersTable::class => CustomersTableFactory::class,
            RegistrationService::class => RegistrationServiceFactory::class,
            LoginService::class => LoginServiceFactory::class,
            TokenService::class => TokenServiceFactory::class,
        ),
        'invokables' => array(
            RegistrationFilter::class => RegistrationFilter::class,
            LoginFilter::class => LoginFilter::class,
            Customers::class => Customers::class,
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);
