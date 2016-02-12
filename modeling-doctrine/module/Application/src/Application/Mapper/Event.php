<?php
namespace Application\Entity;

class Event
{

    protected $id;
    protected $name;
    protected $maxAttendees;
    protected $date;

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
     * @return the $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @return the $maxAttendees
     */
    public function getMaxAttendees()
    {
        return $this->maxAttendees;
    }

    /**
     *
     * @return the $date
     */
    public function getDate()
    {
        return $this->date;
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
     * @param field_type $name            
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     *
     * @param field_type $maxAttendees            
     */
    public function setMaxAttendees($maxAttendees)
    {
        $this->maxAttendees = $maxAttendees;
    }

    /**
     *
     * @param field_type $date            
     */
    public function setDate($date)
    {
        $this->date = $date;
    }
}