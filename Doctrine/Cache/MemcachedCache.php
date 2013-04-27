<?php
namespace Lsw\MemcacheBundle\Doctrine\Cache;

use \Memcached;

use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\CacheProvider;

/**
 * Memcached cache provider (with prefix support).
 *
 * Based on: Doctrine/Common/Cache/MemcacheCache.php
 */
class MemcachedCache extends CacheProvider
{
    /**
     * @var Memcached
     */
    private $memcached;
    /**
     * @var string prefix
     */
    private $prefix;

    /**
     * Sets the memcached instance to use.
     *
     * @param Memcached $memcached
     */
    public function setMemcached(Memcached $memcached)
    {
        $this->memcached = $memcached;
    }

    /**
     * Gets the memcached instance used by the cache.
     *
     * @return Memcached
     */
    public function getMemcached()
    {
        return $this->memcached;
    }

    /**
     * Sets the prefix to use.
     *
     * @param string $prefix
     */
    public function setPrefix($prefix)
    {
      $this->prefix = $prefix;
    }

    /**
     * Gets the prefix used by the cache.
     *
     * @return string
     */
    public function getPrefix()
    {
      return $this->prefix;
    }

    /**
     * {@inheritdoc}
     */
    protected function doFetch($id)
    {
        return $this->memcached->get($this->prefix.$id);
    }

    /**
     * {@inheritdoc}
     */
    protected function doContains($id)
    {
        return (bool) $this->memcached->get($this->prefix.$id);
    }

    /**
     * {@inheritdoc}
     */
    protected function doSave($id, $data, $lifeTime = 0)
    {
        if ($lifeTime > 30 * 24 * 3600) {
            $lifeTime = time() + $lifeTime;
        }
        return $this->memcached->set($this->prefix.$id, $data, (int) $lifeTime);
    }

    /**
     * {@inheritdoc}
     */
    protected function doDelete($id)
    {
        return $this->memcached->delete($this->prefix.$id);
    }

    /**
     * {@inheritdoc}
     */
    protected function doFlush()
    {
        return $this->memcached->flush();
    }

    /**
     * {@inheritdoc}
     */
    protected function doGetStats()
    {
        $stats = $this->memcached->getStats();
        return array(
            Cache::STATS_HITS   => $stats['get_hits'],
            Cache::STATS_MISSES => $stats['get_misses'],
            Cache::STATS_UPTIME => $stats['uptime'],
            Cache::STATS_MEMORY_USAGE       => $stats['bytes'],
            Cache::STATS_MEMORY_AVAILIABLE  => $stats['limit_maxbytes'],
        );
    }
}
