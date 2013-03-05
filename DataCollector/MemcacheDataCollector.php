<?php
namespace Lsw\MemcacheBundle\DataCollector;

use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Lsw\MemcacheBundle\Cache\LoggingMemcache;


/**
 * MemcacheDataCollector
 *
 * @author Maurits van der Schee <m.vanderschee@leaseweb.com>
 */
class MemcacheDataCollector extends DataCollector
{
    private $memcache;

    /**
     * Class constructor
     *
     * @param Lsw\MemcacheBundle\Cache\LoggingMemcache $memcache Logging Memcache object
     */
    public function __construct(LoggingMemcache $memcache = null)
    {
        $this->memcache = $memcache;
    }

    /**
     * {@inheritdoc}
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $this->data = array(
            'calls' => null !== $this->memcache ? $this->memcache->getLoggedCalls() : array(),
        );
    }

    /**
     * Method counts amount of Memcache misses: "get" calls that return "false"
     *
     * @return number
     */
    public function getMissCount()
    {
        $misses = 0;
        foreach ($this->data['calls'] as $call) {
            if ($call->name == 'get') {
                $misses += $call->result === false?1:0;
            }
        }

        return $misses;
    }

    /**
     * Method returns amount of logged Memcache reads: "get" calls
     *
     * @return number
     */
    public function getReadCount()
    {
        $reads = 0;
        foreach ($this->data['calls'] as $call) {
            if ($call->name == 'get') {
                $reads += 1;
            }
        }

        return $reads;
    }

    /**
     * Method returns amount of logged Memcache calls
     *
     * @return number
     */
    public function getCallCount()
    {
        return count($this->data['calls']);
    }

    /**
     * Method returns all logged Memcache call objects
     *
     * @return mixed
     */
    public function getCalls()
    {
        return $this->data['calls'];
    }

    /**
     * Method calculates Memcache calls execution time
     *
     * @return number
     */
    public function getTime()
    {
        $time = 0;
        foreach ($this->data['calls'] as $call) {
            $time += $call->time;
        }

        return $time;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'memcache';
    }
}
