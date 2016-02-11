<?php
/**
 * This module demonstrates putting all critical code into a single file
 * (except for a separate lightweight Event class
 */
namespace Logging;

use Zend\Log\Logger;
use Zend\Log\Writer\Stream;
use Zend\Mvc\MvcEvent;

class Module
{
    
    const LOGGING_EVENT_NOTIFY     = 'logging.event.notify';
    const LOGGING_EVENT_IDENTIFIER = 'logging.event.identifier';
    
    public function onBootstrap(MvcEvent $e)
    {
        $shared = $e->getApplication()->getEventManager()->getSharedManager();        
        // uses an identifier to "channel" which event managers are allowed to trigger this event
        // if you want to allow *any* event manager instance to trigger, change the 1st param to "*"
        $shared->attach('*',
                        self::LOGGING_EVENT_NOTIFY,
                        [$this, 'logStuff']);
    }
    
    public function getServiceConfig()
    {
        return [
            'services' => [
                'logging-event-notify' => self::LOGGING_EVENT_NOTIFY,
            ],
            'factories' => [
                'logging-logger' => function ($sm) {
                    $info = $sm->get('logging-info');
                    $fn   = $info['dir'] . '/' . date('Ymd') . '.log';
                    $logger = new Logger();
                    $logger->addWriter(new Stream($fn));
                    return $logger;
                }
            ],  
        ];
    }
    
    public function logStuff($e)
    {
        $sm      = $e->getParam('serviceManager');
        $message =  $e->getParam('message');
        $logger  = $sm->get('logging-logger');
        $logger->info($message);
    }

}
