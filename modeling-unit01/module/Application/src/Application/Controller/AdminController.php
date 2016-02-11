<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AdminController extends AbstractActionController
{

    public function indexAction()
    {
        $eventId = $this->params('event');

        if ($eventId) {
            return $this->listRegistrations($eventId);
        }

        /** @var \Application\Model\EventTable $eventTable */
        $eventTable = $this->serviceLocator->get('EventTable');
        $events = $eventTable->findAll();
        return new ViewModel(array('events' => $events));
    }

    protected function listRegistrations($eventId)
    {
        /** @var \Application\Model\RegistrationTable $regTable */
        $regTable = $this->serviceLocator->get('RegistrationTable');

        /** @var \Application\Model\AttendeeTable $attendeeTable */
        $attendeeTable = $this->serviceLocator->get('AttendeeTable');

        // alternatively (and probably better) set 2nd param to TRUE
        // it then does a join
        $registrations = $regTable->findAllForEvent($eventId);

        foreach ($registrations as $id => $registration) {
            // this is to be avoided!!!  too many database queries
            $registrations[$id]['attendee'] = $attendeeTable->findAllForRegistration($registration['id']);
        }

        $vm = new ViewModel(array('registrations' => $registrations));
        $vm->setTemplate('application/admin/list.phtml');
        return $vm;
    }

}