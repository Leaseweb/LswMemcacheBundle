<?php
namespace Lsw\MemcacheBundle\Cache;

use Lsw\MemcacheBundle\Cache\LoggingMemcache;

/**
 * Class to encapsulate PHP Memcached object to avoid the "Dog Pile" effect
 */
class AntiDogPileMemcache
{
    const MAX_TTL = 2592000;

    private $memcache;

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
        $this->memcache = new LoggingMemcache($debug, $persistentId);
    }

    public function getAdp($key)
    {
        $value = $this->memcache->get($key, null, &$cas);
        if ($value===false) {
            return false;
        }
        list($exp, $ttl, $val) = explode('|', $value, 3);

        $time = time();
        if ($time>$exp) {
            $value = implode('|', array($time+$ttl, $ttl, $val));
            $result = $this->memcache->cas($cas, $key, $value, 0);

            if ($result) {
                return false;
            }
        }

        return $val;
    }

    public function setAdp($key, $value, $ttl=0)
    {
        if ($ttl === 0) {
            $ttl = self::MAX_TTL;
        }
        $time = time();
        $value = implode('|', array($time+$ttl, $ttl, $value));
        $result = $this->memcache->set($key, $value, 0);

        return $result;
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array(array($this->memcache, $name), $arguments);
    }

}