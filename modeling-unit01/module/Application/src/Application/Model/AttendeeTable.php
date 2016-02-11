<?php

namespace Application\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;

class AttendeeTable implements AdapterAwareInterface
{
    protected $dbAdapter;
    protected $tableGateway;

    public function setAdapter(Adapter $adapter)
    {
        $this->dbAdapter = $adapter;
        $this->tableGateway = new TableGateway('attendee', $adapter);
    }

    public function findAllForRegistration($registrationId, $withAttendees = false)
    {
        $rows = $this->tableGateway->select(array('registration_id' => $registrationId));

        if (!$rows) {
            return false;
        }

        return $rows->toArray();
    }

    public function persist($registrationId, $nameOnTicket)
    {
        $this->tableGateway->insert(array('registration_id' => $registrationId, 'name_on_ticket' => $nameOnTicket));
    }

}