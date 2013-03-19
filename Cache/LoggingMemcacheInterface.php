<?php
namespace Lsw\MemcacheBundle\Cache;

/**
 * Interface to allow for DataCollector to retrieve logged calls
 */
interface LoggingMemcacheInterface
{
    /**
     * Get the logged calls for this Memcached object
     *
     * @return array Array of calls made to the Memcached object
     */
    public function getLoggedCalls();

}