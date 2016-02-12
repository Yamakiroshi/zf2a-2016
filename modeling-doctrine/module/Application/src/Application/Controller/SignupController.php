<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Controller\Plugin\PostRedirectGet;
use Zend\Mvc\Controller\Plugin\Redirect;
use Zend\Mvc\InjectApplicationEventInterface;
use Zend\View\Model\ViewModel;
use Application\Entity\Registration;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Form\FormInterface;

class SignupController extends AbstractActionController 
                       implements InjectApplicationEventInterface, RepoAwareInterface
{

    use RepoTrait;
    
    public function indexAction()
    {
        $eventId = (int) $this->params('event');

        if ($eventId) {
            return $this->eventSignup($eventId);
        }

        $events = $this->eventRepo->findAll();
        return new ViewModel(array('events' => $events));
    }

    public function thanksAction()
    {
        return new ViewModel();
    }

    protected function eventSignup($eventId)
    {
        $form = $this->getServiceLocator()->get('application-registration-form');
        $form->bind($this->getServiceLocator()->get('application-registration-entity'));
        $event = $this->eventRepo->findById($eventId);

        if (!$event) {
            // better 404 experience?
            return $this->notFoundAction();
        }

        if ($this->request->isPost()) {
            if ($this->processForm($event, $form)) {
                return $this->redirect()->toUrl('/thank-you');
            }
        }

        $vm = new ViewModel(array('event' => $event, 'form' => $form));
        $vm->setTemplate('application/signup/form.phtml');
        return $vm;
    }

    protected function processForm($event, $form)
    {
        $formData = $this->params()->fromPost();
        $form->setData($formData);
        if (!$form->isValid()) {
            return FALSE;
        }
        // validate ticket data
        $goodTicket = array();
        $ticketForm = $this->getServiceLocator()->get('application-attendee-form');
        $nameValidator = $ticketForm->getInputFilter()->get('name_on_ticket');
        $ticketData = $formData['ticket'];
        foreach ($ticketData as $nameOnTicket) {
            $nameValidator->setValue($nameOnTicket);
            if (!$nameValidator->isValid()) {
                return FALSE;
            }   
            $goodTicket[] = $nameValidator->getValue();
        }
        // TODO: find out why hydrator is not returning an object
        //$data = $form->getData(FormInterface::VALUES_AS_ARRAY);
        $reg = $form->getData();
        // TODO: rewrite this persist now that we have the object
        $reg = $this->registrationRepo->persist($event, 
                                                $data['first_name'], 
                                                $data['last_name']);
        foreach ($goodTicket as $nameOnTicket) {
            
            $attendee = $this->attendeeRepo->persist($reg, $nameOnTicket);
            $reg->setAttendees($attendee);
            $this->registrationRepo->update($reg);
        }
        
        return true;
    }

}
