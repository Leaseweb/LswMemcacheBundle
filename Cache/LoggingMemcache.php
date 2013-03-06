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
    public function __construct($debug = false)
    {
        $this->debug = $debug;
        if ($this->debug) {
            $this->calls = array();
        }
        if (!class_exists('Memcached')) {
            $class = get_class($this);
            throw new \Exception("Class '$class' depends on the 'Memcached' plugin that is currently not installed");
        }
        $this->memcache = new \Memcached();
        // use the binary protocol for speed optimization
        $this->memcache->setOption(\Memcached::OPT_SERIALIZER, \Memcached::SERIALIZER_JSON);
        $this->memcache->setOption(\Memcached::OPT_BINARY_PROTOCOL,true);
        $this->memcache->setOption(\Memcached::OPT_TCP_NODELAY,true);
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
            $result = call_user_func_array(array($this->memcache, $name), $arguments);
            if ($this->debug) {
                $time = microtime(true) - $start;
                $this->calls[] = (object)compact('start','time','name','arguments','result');
            }
            return $result;
        }
        throw new \Exception("Method 'Memcache::$name' do not exist, see PHP manual.");
    }

}