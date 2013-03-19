<?php
namespace Lsw\MemcacheBundle\Cache;

use Lsw\MemcacheBundle\Cache\LoggingMemcacheInterface;

/**
 * Class to encapsulate PHP Memcached object for unit tests and to add logging in debug mode
 */
class LoggingMemcache implements LoggingMemcacheInterface
{
    private $memcache;
    private $debug;
    private $calls;
    private $initialize;

    /**
     * Constructor instantiates and stores Memcached object
     *
     * @param boolean $debug        Debug mode
     * @param string  $persistentId Identifier for persistent connections
     *
     * @throws \Exception when php Memcached plugin is not installed
     */
    public function __construct($debug = false, $persistentId = null)
    {
        $this->debug = $debug;
        if ($this->debug) {
            $this->calls = array();
        }
        if (!class_exists('Memcached')) {
            $class = get_class($this);
            throw new \Exception("Class '$class' depends on the 'Memcached' plugin that is currently not installed");
        }
        if ($persistentId) {
            $this->memcache = new \Memcached($persistentId);
            $this->initialize = count($this->memcache->getServerList())==0;
        } else {
            $this->memcache = new \Memcached();
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

    /**
     * Magic method to execute Memcached calls
     *
     * @param string $name      Method name
     * @param array  $arguments Method arguments
     *
     * @return mixed
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        if (!$this->initialize) {
            if (in_array($name, array('setOption', 'setOptions', 'addServer', 'addServers', 'setSaslAuthData'))) {
                // ignore calls
                return true;
            }
        }
        if (method_exists($this->memcache, $name)) {
            if ($this->debug) {
                $start = microtime(true);
            }
            // Set call_by_reference for cas_token in the following arguments:
            // Memcached:: get (3)
            // Memcached:: getByKey (4)
            // Memcached:: getMulti (2)
            // Memcached:: getMultiByKey (3)
            $references = array('get'=>2, 'getByKey'=>3, 'getMulti'=>1, 'getMultiByKey'=>2);
            if (isset($references[$name]) && array_key_exists($references[$name],$arguments)) {
                 $arguments[$references[$name]] = &$arguments[$references[$name]];
            }
            $return = call_user_func_array(array($this->memcache, $name), $arguments);
            if ($this->debug) {
                $result = $return;
                $time = microtime(true) - $start;
                $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            }

            return $return;
        }
        throw new \Exception("Method 'Memcached::$name' do not exist, see PHP manual.");
    }

}