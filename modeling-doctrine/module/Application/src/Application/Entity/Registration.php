<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Application\Entity\Attendee;
use Zend\Form\Annotation as ANO;

/**
 * @ANO\Name("registration")
 * @ORM\Entity("Application\Entity\Registration")
 * @ORM\Table("registration")
 */
class Registration
{
    /**
     * @ANO\Exclude()
     * @ORM\Column(type="integer", length=11)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ANO\Type("Zend\Form\Element\Text")
     * @ANO\Options({"label":"First Name"})
     * @ANO\Attributes({"class":"input-xlarge","placeholder":"First Name"})
     * @ANO\Required(TRUE)
     * @ANO\Filter({"name":"StringTrim"})
     * @ANO\Validator({"name":"StringLength", "options":{"min":1, "max":255}})
     * @ANO\Validator({"name":"Alnum", "options":{"AllowWhiteSpace":true}})
     * @ORM\Column(type="string", length=255)
     */
    protected $first_name;
    
    /**
     * @ANO\Type("Zend\Form\Element\Text")
     * @ANO\Options({"label":"Last Name"})
     * @ANO\Attributes({"class":"input-xlarge","placeholder":"Last Name"})
     * @ANO\Required(TRUE)
     * @ANO\Filter({"name":"StringTrim"})
     * @ANO\Validator({"name":"StringLength", "options":{"min":1, "max":255}})
     * @ORM\Column(type="string", length=255)
     */
    protected $last_name;
    
    /**
     * @ANO\Exclude()
     * @ORM\Column(type="datetime")
     */
    protected $registration_time;
    
    /**
     * one registration to many attendees
     * @ANO\Exclude()
     * @ORM\OneToMany(targetEntity="Application\Entity\Attendee", indexBy="id", mappedBy="registration")
     */
    protected $attendees = array();
    
    /**
     * many registrations to one event
     * @ANO\Exclude()
     * @ORM\ManyToOne(targetEntity="Application\Entity\Event", inversedBy="registration")
     */
    protected $event;

    public function __construct()
    {
        $this->attendees = new ArrayCollection();
    }
	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return the $first_name
	 */
	public function getFirst_name() {
		return $this->first_name;
	}

	/**
	 * @return the $last_name
	 */
	public function getLast_name() {
		return $this->last_name;
	}

	/**
	 * @return the $registration_time
	 */
	public function getRegistration_time() {
		return $this->registration_time;
	}

	/**
	 * @return the $attendees
	 */
	public function getAttendees() {
		return $this->attendees;
	}

	/**
	 * @return the $event
	 */
	public function getEvent() {
		return $this->event;
	}

	/**
	 * @param field_type $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @param field_type $first_name
	 */
	public function setFirst_name($first_name) {
		$this->first_name = $first_name;
	}

	/**
	 * @param field_type $last_name
	 */
	public function setLast_name($last_name) {
		$this->last_name = $last_name;
	}

	/**
	 * @param field_type $registration_time
	 */
	public function setRegistration_time($registration_time = NULL) {
	    if ($registration_time == NULL) {
	        $registration_time = new \DateTime('now');
	    }
		$this->registration_time = $registration_time;
	}

	/**
	 * @param multitype: $attendees
	 */
	public function setAttendees(Attendee $attendee) {
		$this->attendees[] = $attendee;
	}

	/**
	 * @param field_type $event
	 */
	public function setEvent($event) {
		$this->event = $event;
	}

    
        
}