<?php
namespace Application\Entity;

class Registration
{

    protected $id;
    protected $event;       // Event entity
    protected $firstName;
    protected $lastName;
    protected $registrationTime;
    protected $attendee;
    
    /**
     * @return the $attendee
     */
    public function getAttendee()
    {
        return $this->attendee;
    }

    /**
     * @param field_type $attendee
     */
    public function setAttendee($attendee)
    {
        $this->attendee[] = $attendee;
    }

    /**
     *
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return the $event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     *
     * @return the $firstName
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     *
     * @return the $lastName
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     *
     * @return the $registrationTime
     */
    public function getRegistrationTime()
    {
        return $this->registrationTime;
    }

    /**
     *
     * @param field_type $id            
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *
     * @param field_type $event            
     */
    public function setEvent($event)
    {
        $this->event = $event;
    }

    /**
     *
     * @param field_type $firstName            
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     *
     * @param field_type $lastName            
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     *
     * @param field_type $registrationTime            
     */
    public function setRegistrationTime($registrationTime)
    {
        $this->registrationTime = $registrationTime;
    }
}