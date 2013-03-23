<?php
namespace Lsw\MemcacheBundle\Cache;

/**
 * Class to encapsulate PHP Memcached object for unit tests and to add logging in logging mode
 */
class LoggingMemcache extends \Memcached implements MemcacheInterface, LoggingMemcacheInterface
{
    private $calls;
    private $initialize;
    private $logging;

    /**
     * Constructor instantiates and stores Memcached object
     *
     * @param string  $persistentId Identifier for persistent connections
     */
    public function __construct($logging = false, $persistentId = null)
    {
        $this->calls = array();
        $this->logging = $logging;
        if ($persistentId) {
            parent::__construct($persistentId);
            $this->initialize = count($this->memcache->getServerList())==0;
        } else {
            parent::__construct();
            $this->initialize = true;
        }
    }

    /**
     * Get the logged calls for this Memcached object
     *
     * @return array Array of calls made to the Memcached object
     */
    public function getLoggedCalls()
    {
        return $this->calls;
    }

    private function logCall($start, $result)
    {
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    // INSERT FUNCTIONS HERE
}