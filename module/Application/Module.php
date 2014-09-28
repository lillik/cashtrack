<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\API\Merchant;
use Application\API\Overview;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getControllerConfig()
    {
        return array(
            'factories' => array(
                'Application\API\Overview' => function ($sm) {
                    $locator    = $sm->getServiceLocator();
                    $reporter   = $locator->get('Reporter\Overview');
                    $controller = new Overview();
                    $controller->setOverviewReporter($reporter);
                    return $controller;
                },

                'Application\API\Merchant' => function ($sm) {
                    $locator    = $sm->getServiceLocator();
                    $controller = new Merchant();
                    $controller->setRepository($locator->get('\Finance\Merchant\Repository'));
                    return $controller;
                },
            ),
        );
    }
}
