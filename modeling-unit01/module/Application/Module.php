<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Model\AttendeeTable;
use Application\Model\EventTable;
use Application\Model\RegistrationTable;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
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

    // Add this method:
    public function getServiceConfig()
    {
        return array(
            'invokables' => array(
                'EventTable' => 'Application\Model\EventTable',
                'AttendeeTable' => 'Application\Model\AttendeeTable',
                'RegistrationTable' => 'Application\Model\RegistrationTable',
            ),
            'initializers' => array(
                'application-inject-adapter' =>  function($table, $sm) {
                    if ($table instanceof \Application\Model\AdapterAwareInterface) {
                        $table->setAdapter($sm->get('Zend\Db\Adapter\Adapter'));
                    }
                },
            ),
        );
    }


}
