<?php
namespace Lsw\MemcacheBundle\Cache;

use Doctrine\Common\Util\Inflector;

/**
 * Class to encapsulate PHP Memcache object for unit tests and to add logging in debug mode
 */
class LoggingMemcache
{
    private $memcache;
    private $debug;
    private $calls;

    /**
     * Constructor instantiates and stores Memcache object
     *
     * @param boolean $debug Debug mode
     *
     * @throws \Exception when php Memcache plugin is not installed
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
        } else {
            $this->memcache = new \Memcached();
        }
    }

    public function getLoggedCalls()
    {
        return $this->calls;
    }

    /**
     * Magic method to execute memcache calls
     *
     * @param string $name      Method name
     * @param array  $arguments Method arguments
     *
     * @return mixed
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        if (method_exists($this->memcache, $name)) {
            if ($this->debug) {
                $start = microtime(true);
            }
            $return = call_user_func_array(array($this->memcache, $name), $arguments);
            if ($this->debug) {
                $result = $return;
                $time = microtime(true) - $start;
                $this->calls[] = (object)compact('start','time','name','arguments','result');
            }
            return $return;
        }
        throw new \Exception("Method 'Memcache::$name' do not exist, see PHP manual.");
    }

}