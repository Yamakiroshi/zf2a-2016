<?php

namespace Application\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Expression;
use Zend\Db\TableGateway\TableGateway;

class RegistrationTable implements AdapterAwareInterface
{
    protected $tableGateway;

    public function setAdapter(Adapter $adapter)
    {
        $this->tableGateway = new TableGateway('registration', $adapter);
    }

    public function findAllForEvent($eventId, $withAttendees = false)
    {

        $select = $this->tableGateway->getSql()->select();
        $select->where(array('event_id' => $eventId));

        if ($withAttendees) {
            $select->join('attendee', 'registration.id = attendee.registration_id', array('name_on_ticket'));
            $rows = $this->tableGateway->selectWith($select);

            if (!$rows) {
                return false;
            }

            $registrations = array();
            foreach ($rows as $row) {
                if (!isset($registrations[$row['id']])) {
                    $registrations[$row['id']] = $row;
                    $registrations[$row['id']]['attendees'] = array();
                }
                $registrations[$row['id']]['attendees'][] = $row['name_on_ticket'];
            }
        } else {
            $rows = $this->tableGateway->selectWith($select);
            if (!$rows) {
                return false;
            }
            $rows = $rows->toArray();
        }

        return $rows;
    }

    public function findById($id)
    {
        $rows = $this->tableGateway->select(array('id' => $id));
        if (!$rows) {
            return false;
        }
        $row = $rows->current();
        return $row->getArrayCopy();
    }

    public function persist($eventId, $firstName, $lastName)
    {
        $this->tableGateway->insert(array(
            'event_id' => $eventId,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'registration_time' => new Expression('NOW()')
        ));

        $id = $this->tableGateway->getLastInsertValue();
        return $this->findById($id);
    }

}