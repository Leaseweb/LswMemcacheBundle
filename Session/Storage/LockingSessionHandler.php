<?php
namespace Lsw\MemcacheBundle\Session\Storage;

/**
 * LockingSessionHandler.
 *
 * Memcache based session storage handler based on the MemcachePool class
 * provided by the PHP memcache extension with added locking support.
 *
 * @see http://php.net/memcache
 *
 * @author Maurits van der Schee <m.vanderschee@leaseweb.com>
 */
class LockingSessionHandler implements \SessionHandlerInterface
{

    /**
     * @var integer Default PHP max execution time in seconds
     */
    const DEFAULT_MAX_EXECUTION_TIME = 30;

    /**
     * @var boolean Indicates an sessions should be locked
     */
    private $locking;

    /**
     * @var boolean Indicates an active session lock
     */
    private $locked;

    /**
     * @var string Session lock key
     */
    private $lockKey;

    /**
     * @var integer Microseconds to wait between acquire lock tries
     */
    private $spinLockWait;

    /**
     * @var integer Maximum amount of seconds to wait for the lock
     */
    private $lockMaxWait;

    /**
     * @var \MemcachePool Memcache driver.
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
     *  * locking: Indicates whether session locking is enabled or not
     *  * spin_lock_wait: Microseconds to wait between acquire lock tries
     *  * lock_max_wait: Maximum amount of seconds to wait for the lock
     *
     * @param \MemcachePool $memcache  A \MemcachePool instance
     * @param array         $options   An associative array of Memcache options
     *
     * @throws \InvalidArgumentException When unsupported options are passed
     */
    public function __construct(\MemcachePool $memcache, array $options = array())
    {
        $this->memcache = $memcache;

        if ($diff = array_diff(array_keys($options), array('prefix', 'expiretime', 'locking', 'spin_lock_wait', 'lock_max_wait'))) {
            throw new \InvalidArgumentException(sprintf(
                'The following options are not supported "%s"', implode(', ', $diff)
            ));
        }

        $this->ttl = isset($options['expiretime']) ? (int) $options['expiretime'] : 86400;
        $this->prefix = isset($options['prefix']) ? $options['prefix'] : 'sf2s';

        $this->locking = $options['locking'];
        $this->locked = false;
        $this->lockKey = null;
        $this->spinLockWait = $options['spin_lock_wait'];
        $this->lockMaxWait = $options['lock_max_wait'] ? $options['lock_max_wait'] : ini_get('max_execution_time');
        if (!$this->lockMaxWait) {
            $this->lockMaxWait = self::DEFAULT_MAX_EXECUTION_TIME;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function open($savePath, $sessionName)
    {
        return true;
    }

    private function lockSession($sessionId)
    {
        $attempts = (1000000 / $this->spinLockWait) * $this->lockMaxWait;

        $this->lockKey = $sessionId.'.lock';
        for ($i=0;$i<$attempts;$i++) {
            $success = $this->memcache->add($this->prefix.$this->lockKey, '1', null, $this->lockMaxWait+1);
            if ($success) {
                $this->locked = true;
                return true;
            }
            usleep($this->spinLockWait);
        }

        return false;
    }

    private function unlockSession()
    {
        $this->memcache->delete($this->prefix.$this->lockKey);
        $this->locked = false;
    }

    /**
     * {@inheritDoc}
     */
    public function close()
    {
        if ($this->locking) {
            if ($this->locked) {
                $this->unlockSession();
            }
        }
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function read($sessionId)
    {
        if ($this->locking) {
            if (!$this->locked) {
                if (!$this->lockSession($sessionId)) {
                    return false;
                }
            }
        }

        return $this->memcache->get($this->prefix.$sessionId) ?: '';
    }

    /**
     * {@inheritDoc}
     */
    public function write($sessionId, $data)
    {
        if ($this->locking) {
            if (!$this->locked) {
                if (!$this->lockSession($sessionId)) {
                    return false;
                }
            }
        }
        
        return $this->memcache->set($this->prefix.$sessionId, $data, null, $this->ttl);
    }

    /**
     * {@inheritDoc}
     */
    public function destroy($sessionId)
    {
        $this->memcache->delete($this->prefix.$sessionId);
        $this->close();
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function gc($lifetime)
    {
        // not required here because memcache will auto expire the records anyhow.
        return true;
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        $this->close();
    }

}
