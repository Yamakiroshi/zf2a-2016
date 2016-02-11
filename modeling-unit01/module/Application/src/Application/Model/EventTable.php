<?php

namespace Application\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;

class EventTable implements AdapterAwareInterface
{
    protected $tableGateway;

    public function setAdapter(Adapter $adapter)
    {
        $this->tableGateway = new TableGateway('event', $adapter);
    }

    public function findAll()
    {
        $rows = $this->tableGateway->select();
        return $rows->toArray();
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

}