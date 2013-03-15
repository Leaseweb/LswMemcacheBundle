<?php
namespace Lsw\MemcacheBundle\Session\Storage\Handler;

use Lsw\MemcacheBundle\Cache\LoggingMemcache;

/**
 * MemcacheSessionHandler.
 *
 * @author Drak <drak@zikula.org>
 */
class MemcacheSessionHandler implements \SessionHandlerInterface
{
    /**
     * @var \Memcached Memcache driver.
     */
    private $memcache;

    /**
     * @var integer Time to live in seconds
     */
    private $ttl;

    /**
     * @var string Key prefix for shared environments.
     */
    private $prefix;

    /**
     * Constructor.
     *
     * List of available options:
     *  * prefix: The prefix to use for the memcache keys in order to avoid collision
     *  * expiretime: The time to live in seconds
     *
     * @param \Memcache $memcache A \Memcache client
     * @param array     $options  An associative array of Memcache options
     *
     * @throws \InvalidArgumentException When unsupported options are passed
     */
    public function __construct(LoggingMemcache $memcache, array $options = array())
    {
        if ($diff = array_diff(array_keys($options), array('prefix', 'expiretime'))) {
            throw new \InvalidArgumentException(sprintf(
                'The following options are not supported "%s"', implode(', ', $diff)
            ));
        }

        $this->memcache = $memcache;
        $this->ttl = isset($options['expiretime']) ? (int) $options['expiretime'] : 86400;
        $this->prefix = isset($options['prefix']) ? $options['prefix'] : 'session_';
    }

    /**
     * {@inheritDoc}
     */
    public function open($savePath, $sessionName)
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function close()
    {
        // not required here because memcached has no close function.
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function read($sessionId)
    {
        return $this->memcache->get($this->prefix.$sessionId) ?: '';
    }

    /**
     * {@inheritDoc}
     */
    public function write($sessionId, $data)
    {
        return $this->memcache->set($this->prefix.$sessionId, $data, time() + $this->ttl);
    }

    /**
     * {@inheritDoc}
     */
    public function destroy($sessionId)
    {
        return $this->memcache->delete($this->prefix.$sessionId);
    }

    /**
     * {@inheritDoc}
     */
    public function gc($lifetime)
    {
        // not required here because memcache will auto expire the records anyhow.
        return true;
    }
}