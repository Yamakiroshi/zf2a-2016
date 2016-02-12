<?php
namespace Application\Entity;

use Zend\Stdlib\Hydrator\HydrationInterface;
class Attendee implements HydrationInterface
{

    public function arrayToEntity($data)
    {
        $entity = new Attendee();
        $entity->setId($data['id']);         
        $entity->setRegistration($data['registration']);
        $entity->setName($data['name']);
        return $entity;
    }

    public function entityToArray($data, $entity = NULL)
    {
        if (!$entity) {
            $entity = new Attendee();
        }
        $data['id'] = $entity->getId();         
        $data['registration'] = $entity->getRegistration();
        $data['name'] = $entity->getName();
        return $entity;
    }

    public function hydrate($data, $entity = NULL)
    {
        return $this->entityToArray($data, $entity);
    }
    
    public function extract($data)
    {
        return $this->arrayToEntity($data);
    }
}