<?php
namespace Lsw\MemcacheBundle\Cache;

/**
 * Interface to allow for DataCollector to retrieve logged calls
 */
interface LoggingMemcacheInterface
{
    /**
     * Get the logged calls for this Memcache object
     *
     * @return array Array of calls made to the Memcache object
     */
    public function getLoggedCalls();

}