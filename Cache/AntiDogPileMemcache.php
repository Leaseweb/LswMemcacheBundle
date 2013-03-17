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

    public function getAdp($key, $cacheCallback = null, &$casToken = null)
    {
        $exp = $this->memcache->get($key.'_expire', null, &$cas);
        if ($exp === false) {
            return false;
        }
        $ttl = $this->memcache->get($key.'_ttl');
        if ($ttl === false) {
            return false;
        }
        $time = time();
        if ($time>$exp) {
            $result = $this->memcache->cas($cas, $key.'_expire', $time+$ttl, 0);

            if ($result) {
                return false;
            }
        }

        return $this->memcache->get($key.'_value', $cacheCallback, &$casToken);
    }

    public function setAdp($key, $value, $ttl=0)
    {
        if ($ttl === 0) {
            $ttl = self::MAX_TTL;
        }
        $time = time();
        $result = $this->memcache->set($key.'_expire', $time+$ttl, 0);
        $result = $this->memcache->set($key.'_ttl', $ttl, 0);
        $result = $this->memcache->set($key.'_value', $value, 0);

        return $result;
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array(array($this->memcache, $name), $arguments);
    }

}