<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace CartApi;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use CustomerApi\Listener\AuthListener;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $sm = $e->getApplication()->getServiceManager();

        // attach auth listener on every controller dispatch event
        $eventManager->getSharedManager()->attach(
            'SecuredController',
            'dispatch',
            function ($e) use ($sm) {
                $authListener = new AuthListener();
                return $authListener($e);
            },
            2
        );

    }

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
