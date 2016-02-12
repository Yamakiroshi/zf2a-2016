<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Repository\AttendeeRepo;
use Application\Repository\EventRepo;
use Application\Repository\RegistrationRepo;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Doctrine\ORM\Mapping\ClassMetadata;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Stdlib\Hydrator\ClassMethods;

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

    public function getControllerConfig()
    {
        return array(
          'initializers' => array(
              'application-inject-repos' => function ($instance, $cm) {
                  if ($instance instanceof \Application\Controller\RepoAwareInterface) {
                      $sm = $cm->getServiceLocator();
                      $instance->setEventRepo($sm->get('application-repo-event'));
                      $instance->setAttendeeRepo($sm->get('application-repo-attendee'));
                      $instance->setRegistrationRepo($sm->get('application-repo-registration'));
                  }
              }
          ),
          'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController',
            'Application\Controller\Signup' => 'Application\Controller\SignupController',
            'Application\Controller\Admin' => 'Application\Controller\AdminController',
          ),  
        );
    }
    // Add this method:
    public function getServiceConfig()
    {
        return array(
            'invokables' => array(
                'application-builder' => 'Zend\Form\Annotation\AnnotationBuilder',
                'application-registration-entity' => 'Application\Entity\Registration',
            ),
            'factories' => array(
                'application-class-methods-hydrator' => function ($sm) {
                    $hydrator = new ClassMethods();
                    // because our class uses property names with '_', by default these are
                    // converted to camel case.  So if we have a property "last_name",
                    // the ClassMethods hydrator will assume the setter is setLastName!
                    // If we remove the "UnderscoreNamingStrategy" we allow the "_" to remain
                    $hydrator->removeNamingStrategy('UnderscoreNamingStrategy');
                    //var_dump($hydrator->getNamingStrategy('*')); exit;
                    return $hydrator;
                },
                'application-doctrine-hydrator' => function ($sm) {
                    return new DoctrineObject($sm->get('doctrine.entitymanager.orm_default'));
                },
                'application-repo-attendee'    => function ($sm) {
                    $em = $sm->get('doctrine.entitymanager.orm_default');
                    return new AttendeeRepo($em, $em->getClassMetadata('Application\Entity\Attendee'));
                },
                'application-repo-event'       => function ($sm) {
                    $em = $sm->get('doctrine.entitymanager.orm_default');
                    return new EventRepo($em, $em->getClassMetadata('Application\Entity\Event'));
                },
                'application-repo-registration'=> function ($sm) {
                    $em = $sm->get('doctrine.entitymanager.orm_default');
                    return new RegistrationRepo($em, $em->getClassMetadata('Application\Entity\Registration'));
                },
                'application-registration-form' => function ($sm) {
                    // should also implement cache as it takes some
                    // resources to always build the form this way
                    $builder = $sm->get('application-builder');
                    $form = $builder->createForm('Application\Entity\Registration');
                    $hydrator = $sm->get('application-class-methods-hydrator');
                    $form->setHydrator($hydrator);
                    return $form;
                },
                'application-attendee-form' => function ($sm) {
                    $builder = $sm->get('application-builder');
                    return $builder->createForm('Application\Entity\Attendee');
                }
            ),
        );
    }


}
