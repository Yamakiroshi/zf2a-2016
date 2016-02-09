<?php
/**
 * Don't forget to change the namespace from "PhlyContact" 
 * to "Application" after copying this file!
 */
namespace Application\Service;
use Application\Controller\ContactController;
use Zend\Mail\Message;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ContactControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
        $serviceLocator = $services->getServiceLocator();
        $form           = $serviceLocator->get('PhlyContactForm');
        /**
		 * NOTE: these services will be "lazy-loaded" in the lab.
		 * This file will be copied into the "Application" module structure.
		 * In the lab you will remove the following 2 lines after copying.
         */
        //$message        = $serviceLocator->get('PhlyContactMailMessage');
        //$transport      = $serviceLocator->get('PhlyContactMailTransport');

        $controller = new ContactController();
        $controller->setContactForm($form);
        
        /**
		 * In the lab you will also remove these 2 lines after copying.
         */
        $controller->setMessage($message);
        $controller->setMailTransport($transport);
        
        return $controller;
    }
}
