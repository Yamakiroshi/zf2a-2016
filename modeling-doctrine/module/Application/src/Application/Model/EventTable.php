<?php
namespace Application\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;
class EventTable
{
    protected $tablegateway;
    protected $tableName = 'event';
    
    public function __construct(Adapter $adapter)
    {
        $this->tablegateway = new TableGateway($this->getTableName(), $adapter);
    }

    public function findAll()
    {
        return $this->tablegateway->select()->toArray();
    }
    
    public function findById($id)
    {
        return $this->tablegateway->select(array('id' => $id))->current()->getArrayCopy();
    }
    
    /**
     * @return the $tablegateway
     */
    public function getTablegateway()
    {
        return $this->tablegateway;
    }


    /**
     * @return the $tableName
     */
    public function getTableName()
    {
        return $this->tableName;
    }


    /**
     * @param field_type $tablegateway
     */
    public function setTablegateway($tablegateway)
    {
        $this->tablegateway = $tablegateway;
    }


    /**
     * @param string $tableName
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }

    
}