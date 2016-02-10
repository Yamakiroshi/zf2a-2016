<?php
namespace Cache;

class Module
{
    // see config/autoload/cache.local.php
/*
 * $cache   = \Zend\Cache\StorageFactory::factory( [
    'adapter' => [
        'name' => 'filesystem',
        'options' => [
            'ttl' => 3600,
            'cache_dir' => __DIR__ . '/../../data/cache',
        ],
    ],
    'plugins' => [
        // Don't throw exceptions on cache errors
        'exception_handler' => [
            'throw_exceptions' => false
        ],
    ]
]];
 */    
    // define a cache service
    // attach a listener to the ??? event
    // have the listener cache the output (i.e. response object) when viewing items in a category
    // need to define a trigger to refresh cache!!!
}