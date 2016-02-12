<?php
namespace Application\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;
class AttendeeTable
{
    protected $tablegateway;
    protected $tableName = 'attendee';
    
    public function __construct(Adapter $adapter)
    {
        $this->tablegateway = new TableGateway($this->getTableName(), $adapter);
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