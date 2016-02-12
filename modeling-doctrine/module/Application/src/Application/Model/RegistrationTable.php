<?php
namespace Application\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;
class RegistrationTable
{
    protected $tablegateway;
    protected $tableName = 'registration';
    
    public function __construct(Adapter $adapter)
    {
        $this->tablegateway = new TableGateway($this->getTableName(), $adapter);
    }

    public function persist($eventId, $first_name, $last_name)
    {
        $this->tablegateway->insert(array('event_id' => $eventId,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'registration_time' => date('Y-m-d H:i:s')));
        return $this->tablegateway->getLastInsertValue();
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