<?php
namespace Application\Repository;

use Doctrine\ORM\EntityRepository;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Application\Entity\Registration;

class RegistrationRepo extends EntityRepository implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    
    /**
     * @param Application\Entity\Event $eventEntity
     * @param string $firstName
     * @param string $lastName
     * @return Application\Entity\Registration $registration
     */
    public function persist($eventEntity, $firstName, $lastName)
    {
        $registration = new Registration();
        $registration->setFirst_name($firstName);
        $registration->setLast_name($lastName);
        $registration->setEvent($eventEntity);
        $registration->setRegistration_time(new \DateTime('now'));
        return $this->update($registration);
    }
    public function update($registration)
    {
        $em = $this->getEntityManager();
        $em->persist($registration);
        $em->flush();
        return $registration;
    }
} 