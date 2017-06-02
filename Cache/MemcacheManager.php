<?php

namespace Lsw\MemcacheBundle\Cache;

/**
 * Central class to manage single memcache instances.
 *
 * @author David Geistert <david@geistert.info>
 */
class MemcacheManager
{
    /**
     * Registered memcache pools.
     *
     * @var MemcacheInterface[]
     */
    private $pools;

    /**
     * Inititialize empty pool collection.
     */
    public function __construct()
    {
        $this->pools = array();
    }

    /**
     * Add registered memcache.
     *
     * @param string            $name     memcache name obtained from config
     * @param MemcacheInterface $memcache
     */
    public function addMemcachePool($name, MemcacheInterface $memcache)
    {
        $this->pools[$name] = $memcache;
    }

    /**
     * Get memcache service by name if it exists.
     *
     * @param string $name memcache name
     *
     * @return null|MemcacheInterface
     */
    public function getMemcache($name)
    {
        if (array_key_exists($name, $this->pools)) {
            return $this->pools[$name];
        }
    }

    /**
     * Get all memcache pools.
     *
     * @return array
     */
    public function getMemcaches()
    {
        return $this->pools;
    }

    /**
     * Flush memcache by name.
     *
     * @param string $name memcache name
     *
     * @return bool TRUE if flush was successful, FALSE otherwise
     */
    public function flushMemcache($name)
    {
        if ($memcache = $this->getMemcache($name)) {
            return $memcache->flush();
        } else {
            return false;
        }
    }

    /**
     * Flush all registered memcaches.
     */
    public function flushAllMemcaches()
    {
        foreach ($this->pools as $memcache) {
            $memcache->flush();
        }
    }
}
