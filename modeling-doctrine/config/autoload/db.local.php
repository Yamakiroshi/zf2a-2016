<?php
/** -- Task
 * Define parameters appropriate for your environment using the "db" key as follows:
 * Driver: pdo_mysql
 * Host: localhost
 * Username: zend
 * Password: password
 * Driver Options:
 * PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
 * PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
 */
return array(
    'db' => array(
        'driver'         => 'pdo',
        'dsn'            => 'mysql:dbname=registrator;host=localhost',
        'username'       => 'zend',
        'password'       => 'password',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",
            // NOTE: change to PDO::ERRMODE_SILENT for production!
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
        ),
    ),
	'service_manager' => array(
		'factories' => array(
			'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
		),
	),
    'doctrine' => array(
        'driver' => array(
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            'my_annotation_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../../../module/Application/src/Application/Entity',
                ),
            ),

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => array(
                'drivers' => array(
                    // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                    'Application\Entity' => 'my_annotation_driver'
                )
            )
        ),
        'connection' => array(
            // default connection name
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'host'     => 'localhost',
                    'port'     => '3306',
                    'user'     => 'zend',
                    'password' => 'password',
                    'dbname'   => 'registrator',
                )
            )
        )
    ),
);
