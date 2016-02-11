<?php
namespace Application\Model;

use Zend\Db\Adapter\Adapter;
interface AdapterAwareInterface
{
    public function setAdapter(Adapter $adapter);
}