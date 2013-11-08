<?php
namespace Lsw\MemcacheBundle\Session\Storage;

/**
 * LockingSessionHandler.
 *
 * Memcached based session storage handler based on the Memcached class
 * provided by the PHP memcached extension.
 *
 * @see http://php.net/memcached
 *
 * @author Maurits van der Schee <m.vanderschee@leaseweb.com>
 */
class LockingSessionHandler implements \SessionHandlerInterface
{

    const MEMC_SESS_DEFAULT_LOCK_WAIT  = 150000;
    const MEMC_SESS_LOCK_EXPIRATION  = 30;

    private $locked;
    private $lockKey;
    private $lockWait;
    private $lockMaxWait;

    /**
     * @var \Memcached Memcached driver.
     */
    private $memcached;

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
     *  * prefix: The prefix to use for the memcached keys in order to avoid collision
     *  * expiretime: The time to live in seconds
     *
     * @param \Memcached $memcached A \Memcached instance
     * @param array      $options   An associative array of Memcached options
     *
     * @throws \InvalidArgumentException When unsupported options are passed
     */
    public function __construct(\Memcached $memcached, array $options = array())
    {
        $this->memcached = $memcached;

        if ($diff = array_diff(array_keys($options), array('prefix', 'expiretime'))) {
            throw new \InvalidArgumentException(sprintf(
                'The following options are not supported "%s"', implode(', ', $diff)
            ));
        }

        $this->ttl = isset($options['expiretime']) ? (int) $options['expiretime'] : 86400;
        $this->prefix = isset($options['prefix']) ? $options['prefix'] : 'sf2s';

        // added for locking

        $this->locked = 0;
        $this->lockKey = null;
        $this->lockWait = ini_get('memcached.sess_lock_wait');
        if ($this->lockWait == 0) {
            $this->lockWait = self::MEMC_SESS_DEFAULT_LOCK_WAIT;
        }
        $this->lockMaxWait = ini_get('max_execution_time');
        if ($this->lockMaxWait === false) {
            $this->lockMaxWait = self::MEMC_SESS_LOCK_EXPIRATION;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function open($savePath, $sessionId)
    {
        if (!$this->locked) {
            if (!$this->lockSession($sessionId)) {
                return false;
            }
        }
        return true;
    }

    private function lockSession($sessionId)
    {
        $expiration  = time() + $this->lockMaxWait + 1;
        $attempts = (1000000 / $this->lockWait) * $this->lockMaxWait;

        $this->lockKey = $sessionId.'.lock';
        for ($i=0;$i<$attempts;$i++) {
            $success = $this->memcached->add($this->prefix.$this->lockKey, '1', $expiration);
            if ($success) {
                $this->locked = 1;
                return true;
            }
            $status = $this->memcached->getResultCode();
            if ($status != \Memcached::RES_NOTSTORED && $status != \Memcached::RES_DATA_EXISTS) {
                break;
            }
            usleep($this->lockWait);
        }

        return false;
    }

    private function unlockSession()
    {
        $this->memcached->delete($this->prefix.$this->lockKey);
        $this->locked = 0;
    }

    /**
     * {@inheritDoc}
     */
    public function close()
    {
        if ($this->locked) {
            $this->unlockSession();
        }
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function read($sessionId)
    {
        return $this->memcached->get($this->prefix.$sessionId) ?: '';
    }

    /**
     * {@inheritDoc}
     */
    public function write($sessionId, $data)
    {
        return $this->memcached->set($this->prefix.$sessionId, $data, time() + $this->ttl);
    }

    /**
     * {@inheritDoc}
     */
    public function destroy($sessionId)
    {
        $this->memcached->delete($this->prefix.$sessionId);
        $this->close();
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function gc($lifetime)
    {
        // not required here because memcached will auto expire the records anyhow.
        return true;
    }
}