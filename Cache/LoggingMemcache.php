<?php
namespace Lsw\MemcacheBundle\Cache;

use Lsw\MemcacheBundle\Cache\LoggingMemcacheInterface;

/**
 * Class to encapsulate PHP Memcached object for unit tests and to add logging in logging mode
 */
class LoggingMemcache extends \Memcached implements MemcacheInterface, LoggingMemcacheInterface
{
    private $calls;
    private $initialize;
    private $logging;

    /**
     * Constructor instantiates and stores Memcached object
     *
     * @param string  $persistentId Identifier for persistent connections
     */
    public function __construct($logging = false, $persistentId = null)
    {
        $this->calls = array();
        $this->logging = $logging;
        if ($persistentId) {
            parent::__construct($persistentId);
            $this->initialize = count($this->memcache->getServerList())==0;
        } else {
            parent::__construct();
            $this->initialize = true;
        }
    }

    /**
     * Get the logged calls for this Memcached object
     *
     * @return array Array of calls made to the Memcached object
     */
    public function getLoggedCalls()
    {
        return $this->calls;
    }

    private function logCall($start, $result)
    {
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function getResultCode()
    {   
        if (!$this->logging) return parent::getResultCode();
        $start = microtime(true);
        $name = 'getResultCode';
        $result = parent::getResultCode();
        $arguments = array();
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function getResultMessage()
    {   
        if (!$this->logging) return parent::getResultMessage();
        $start = microtime(true);
        $name = 'getResultMessage';
        $result = parent::getResultMessage();
        $arguments = array();
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function get($key, $cache_cb = null, &$cas_token = null)
    {   
        if (!$this->logging) return parent::get($key, $cache_cb, $cas_token);
        $start = microtime(true);
        $name = 'get';
        $result = parent::get($key, $cache_cb, $cas_token);
        $arguments = array($key, $cache_cb, $cas_token);
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function getByKey($server_key, $key, $cache_cb = null, &$cas_token = null)
    {   
        if (!$this->logging) return parent::getByKey($server_key, $key, $cache_cb, $cas_token);
        $start = microtime(true);
        $name = 'getByKey';
        $result = parent::getByKey($server_key, $key, $cache_cb, $cas_token);
        $arguments = array($server_key, $key, $cache_cb, $cas_token);
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function getMulti(array $keys, &$cas_tokens = null, $flags = null)
    {   
        if (!$this->logging) return parent::getMulti($keys, $cas_tokens, $flags);
        $start = microtime(true);
        $name = 'getMulti';
        $result = parent::getMulti($keys, $cas_tokens, $flags);
        $arguments = array($keys, $cas_tokens, $flags);
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function getMultiByKey($server_key, array $keys, &$cas_tokens = null, $flags = null)
    {   
        if (!$this->logging) return parent::getMultiByKey($server_key, $keys, $cas_tokens, $flags);
        $start = microtime(true);
        $name = 'getMultiByKey';
        $result = parent::getMultiByKey($server_key, $keys, $cas_tokens, $flags);
        $arguments = array($server_key, $keys, $cas_tokens, $flags);
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function getDelayed(array $keys, $with_cas = null, $value_cb = null)
    {   
        if (!$this->logging) return parent::getDelayed($keys, $with_cas, $value_cb);
        $start = microtime(true);
        $name = 'getDelayed';
        $result = parent::getDelayed($keys, $with_cas, $value_cb);
        $arguments = array($keys, $with_cas, $value_cb);
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function getDelayedByKey($server_key, array $keys, $with_cas = null, $value_cb = null)
    {   
        if (!$this->logging) return parent::getDelayedByKey($server_key, $keys, $with_cas, $value_cb);
        $start = microtime(true);
        $name = 'getDelayedByKey';
        $result = parent::getDelayedByKey($server_key, $keys, $with_cas, $value_cb);
        $arguments = array($server_key, $keys, $with_cas, $value_cb);
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function fetch()
    {   
        if (!$this->logging) return parent::fetch();
        $start = microtime(true);
        $name = 'fetch';
        $result = parent::fetch();
        $arguments = array();
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function fetchAll()
    {   
        if (!$this->logging) return parent::fetchAll();
        $start = microtime(true);
        $name = 'fetchAll';
        $result = parent::fetchAll();
        $arguments = array();
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function set($key, $value, $expiration = null)
    {   
        if (!$this->logging) return parent::set($key, $value, $expiration);
        $start = microtime(true);
        $name = 'set';
        $result = parent::set($key, $value, $expiration);
        $arguments = array($key, $value, $expiration);
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function setByKey($server_key, $key, $value, $expiration = null)
    {   
        if (!$this->logging) return parent::setByKey($server_key, $key, $value, $expiration);
        $start = microtime(true);
        $name = 'setByKey';
        $result = parent::setByKey($server_key, $key, $value, $expiration);
        $arguments = array($server_key, $key, $value, $expiration);
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function setMulti(array $items, $expiration = null)
    {   
        if (!$this->logging) return parent::setMulti($items, $expiration);
        $start = microtime(true);
        $name = 'setMulti';
        $result = parent::setMulti($items, $expiration);
        $arguments = array($items, $expiration);
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function setMultiByKey($server_key, array $items, $expiration = null)
    {   
        if (!$this->logging) return parent::setMultiByKey($server_key, $items, $expiration);
        $start = microtime(true);
        $name = 'setMultiByKey';
        $result = parent::setMultiByKey($server_key, $items, $expiration);
        $arguments = array($server_key, $items, $expiration);
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function cas($cas_token, $key, $value, $expiration = null)
    {   
        if (!$this->logging) return parent::cas($cas_token, $key, $value, $expiration);
        $start = microtime(true);
        $name = 'cas';
        $result = parent::cas($cas_token, $key, $value, $expiration);
        $arguments = array($cas_token, $key, $value, $expiration);
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function casByKey($cas_token, $server_key, $key, $value, $expiration = null)
    {   
        if (!$this->logging) return parent::casByKey($cas_token, $server_key, $key, $value, $expiration);
        $start = microtime(true);
        $name = 'casByKey';
        $result = parent::casByKey($cas_token, $server_key, $key, $value, $expiration);
        $arguments = array($cas_token, $server_key, $key, $value, $expiration);
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function add($key, $value, $expiration = null)
    {   
        if (!$this->logging) return parent::add($key, $value, $expiration);
        $start = microtime(true);
        $name = 'add';
        $result = parent::add($key, $value, $expiration);
        $arguments = array($key, $value, $expiration);
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function addByKey($server_key, $key, $value, $expiration = null)
    {   
        if (!$this->logging) return parent::addByKey($server_key, $key, $value, $expiration);
        $start = microtime(true);
        $name = 'addByKey';
        $result = parent::addByKey($server_key, $key, $value, $expiration);
        $arguments = array($server_key, $key, $value, $expiration);
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function append($key, $value, $expiration = null)
    {   
        if (!$this->logging) return parent::append($key, $value, $expiration);
        $start = microtime(true);
        $name = 'append';
        $result = parent::append($key, $value, $expiration);
        $arguments = array($key, $value, $expiration);
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function appendByKey($server_key, $key, $value, $expiration = null)
    {   
        if (!$this->logging) return parent::appendByKey($server_key, $key, $value, $expiration);
        $start = microtime(true);
        $name = 'appendByKey';
        $result = parent::appendByKey($server_key, $key, $value, $expiration);
        $arguments = array($server_key, $key, $value, $expiration);
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function prepend($key, $value, $expiration = null)
    {   
        if (!$this->logging) return parent::prepend($key, $value, $expiration);
        $start = microtime(true);
        $name = 'prepend';
        $result = parent::prepend($key, $value, $expiration);
        $arguments = array($key, $value, $expiration);
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function prependByKey($server_key, $key, $value, $expiration = null)
    {   
        if (!$this->logging) return parent::prependByKey($server_key, $key, $value, $expiration);
        $start = microtime(true);
        $name = 'prependByKey';
        $result = parent::prependByKey($server_key, $key, $value, $expiration);
        $arguments = array($server_key, $key, $value, $expiration);
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function replace($key, $value, $expiration = null)
    {   
        if (!$this->logging) return parent::replace($key, $value, $expiration);
        $start = microtime(true);
        $name = 'replace';
        $result = parent::replace($key, $value, $expiration);
        $arguments = array($key, $value, $expiration);
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function replaceByKey($server_key, $key, $value, $expiration = null)
    {   
        if (!$this->logging) return parent::replaceByKey($server_key, $key, $value, $expiration);
        $start = microtime(true);
        $name = 'replaceByKey';
        $result = parent::replaceByKey($server_key, $key, $value, $expiration);
        $arguments = array($server_key, $key, $value, $expiration);
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function delete($key, $time = null)
    {   
        if (!$this->logging) return parent::delete($key, $time);
        $start = microtime(true);
        $name = 'delete';
        $result = parent::delete($key, $time);
        $arguments = array($key, $time);
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function deleteByKey($server_key, $key, $time = null)
    {   
        if (!$this->logging) return parent::deleteByKey($server_key, $key, $time);
        $start = microtime(true);
        $name = 'deleteByKey';
        $result = parent::deleteByKey($server_key, $key, $time);
        $arguments = array($server_key, $key, $time);
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function increment($key, $offset = null)
    {   
        if (!$this->logging) return parent::increment($key, $offset);
        $start = microtime(true);
        $name = 'increment';
        $result = parent::increment($key, $offset);
        $arguments = array($key, $offset);
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function decrement($key, $offset = null)
    {   
        if (!$this->logging) return parent::decrement($key, $offset);
        $start = microtime(true);
        $name = 'decrement';
        $result = parent::decrement($key, $offset);
        $arguments = array($key, $offset);
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function addServer($host, $port, $weight = null)
    {   
        if (!$this->logging) return parent::addServer($host, $port, $weight);
        $start = microtime(true);
        $name = 'addServer';
        $result = parent::addServer($host, $port, $weight);
        $arguments = array($host, $port, $weight);
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function addServers(array $servers)
    {   
        if (!$this->logging) return parent::addServers($servers);
        $start = microtime(true);
        $name = 'addServers';
        $result = parent::addServers($servers);
        $arguments = array($servers);
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function getServerList()
    {   
        if (!$this->logging) return parent::getServerList();
        $start = microtime(true);
        $name = 'getServerList';
        $result = parent::getServerList();
        $arguments = array();
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function getServerByKey($server_key)
    {   
        if (!$this->logging) return parent::getServerByKey($server_key);
        $start = microtime(true);
        $name = 'getServerByKey';
        $result = parent::getServerByKey($server_key);
        $arguments = array($server_key);
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function getStats()
    {   
        if (!$this->logging) return parent::getStats();
        $start = microtime(true);
        $name = 'getStats';
        $result = parent::getStats();
        $arguments = array();
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function getVersion()
    {   
        if (!$this->logging) return parent::getVersion();
        $start = microtime(true);
        $name = 'getVersion';
        $result = parent::getVersion();
        $arguments = array();
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function flush($delay = null)
    {   
        if (!$this->logging) return parent::flush($delay);
        $start = microtime(true);
        $name = 'flush';
        $result = parent::flush($delay);
        $arguments = array($delay);
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function getOption($option)
    {   
        if (!$this->logging) return parent::getOption($option);
        $start = microtime(true);
        $name = 'getOption';
        $result = parent::getOption($option);
        $arguments = array($option);
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }

    public function setOption($option, $value)
    {   
        if (!$this->logging) return parent::setOption($option, $value);
        $start = microtime(true);
        $name = 'setOption';
        $result = parent::setOption($option, $value);
        $arguments = array($option, $value);
        $time = microtime(true) - $start;
        $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return $result;
    }
}