<?php
namespace Lsw\MemcacheBundle\Firewall;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

/**
 * FirewallHandler.
 *
 * This Firewall Handler class allows to throttle concurrent requests.
 *
 * @author Maurits van der Schee <m.vanderschee@leaseweb.com>
 */
class FirewallHandler
{

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
	 * @var string Key prefix for shared environments.
	 */
	private $prefix;
	
	/**
	 * @var integer Number of allowed concurrent requests.
	 */
	private $concurrency;
	
	/**
	 * @var array List of reverse proxies that should be trusted.
	 */
	private $reverseProxies;
	
	/**
	 * @var string The name of the header field that holds the client IP address.
	 */
	private $xForwardedFor;
	
	/**
	 * @var boolean Keep track of concurrency counter increment
	 */
	private $incremented;

	/**
	 * @var string Key that is used in this request as the concurrency counter
	 */
	private $key;
	
	/**
	 * Constructor.
	 *
     * List of available options:
     *  * prefix: The prefix to use for the memcache keys in order to avoid collision
     *  * concurrency: The time to live in seconds
     *  * reverse_proxies: List of reverse proxies that should be trusted
     *  * x_forwarded_for: The name of the header field that holds the client IP address
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
	
		if ($diff = array_diff(array_keys($options), array('prefix', 'concurrency', 'reverse_proxies', 'x_forwarded_for', 'spin_lock_wait', 'lock_max_wait'))) {
			throw new \InvalidArgumentException(sprintf(
					'The following options are not supported "%s"', implode(', ', $diff)
			));
		}
	
		$this->prefix = $options['prefix'];
		$this->concurrency = $options['concurrency'];
		$this->reverseProxies = $options['reverse_proxies'];
		$this->xForwardedFor = $options['x_forwarded_for'];
		$this->spinLockWait = $options['spin_lock_wait'];
		$this->lockMaxWait = $options['lock_max_wait'];
		$this->incremented = false;
		$this->key = false;
	}	
	
	/**
	 * If the current concurrency is too high, delay or throw a TooManyRequestsHttpException
	 *
	 * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event Event
	 *
	 * @throws \Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException
	 */
	public function onKernelRequest(GetResponseEvent $event)
	{
		if (!$event->isMasterRequest()) {
			return;
		}
		
		$request = $event->getRequest();
		if ($this->reverseProxies) {
			$request->setTrustedProxies($this->reverseProxies);
		}
		if ($this->xForwardedFor) {
			$request->setTrustedHeaderName(Request::HEADER_CLIENT_IP, $this->xForwardedFor);
		}
		
		$ip = $request->getClientIp();
		$start = microtime(true);

		$this->key=$this->prefix.'_'.$ip;
		
		$this->memcache->add($this->key,0,false,$this->lockMaxWait);
		while (true) {
			$this->incremented = true;
			if ($this->memcache->increment($this->key)<=$this->concurrency) {
				break;
			}
			$this->incremented = false;
			$this->memcache->decrement($this->key);
			if (!$this->spinLockWait || microtime(true)-$start>$this->lockMaxWait) {
				throw new TooManyRequestsHttpException();
			}
			usleep($this->spinLockWait);
		}
	}
	
	/**
	 * If the current request has ended, decrement concurrency counter
	 *
	 * @param \Symfony\Component\HttpKernel\Event\PostResponseEvent $event Event
	 *
	 */
	public function onKernelTerminate(PostResponseEvent $event)
	{
		if (!$this->incremented) {
			return;
		}
		
		$this->incremented = false;
		$this->memcache->decrement($this->key);
	}
	
}