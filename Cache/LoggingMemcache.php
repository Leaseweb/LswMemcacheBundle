<?php
namespace Lsw\MemcacheBundle\Cache;

$extension = new \ReflectionExtension('memcached');
if ($extension->getVersion()=='1.0.2') {
    class LoggingMemcache extends \Memcached implements MemcacheInterface, LoggingMemcacheInterface {
        public function __construct($logging, $persistent_id = '') {
            $this->calls = array();
            $this->logging = $logging;
            if ($persistent_id) {
                $this->initialize = count($this->getServerList())==0;
            } else {
                $this->initialize = true;
            }
            parent::__construct($persistent_id);
        }
        private $calls;
        private $initialize;
        private $logging;
        public function getLoggedCalls() {
            return $this->calls;
        }
        private function logCall($start, $result) {
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function get( $key, $cache_cb = null, &$cas_token = null ) {
            if (!$this->logging) return parent::get($key,$cache_cb,$cas_token);
            $start = microtime(true);
            $name = 'get';
            $arguments = array($key,$cache_cb,$cas_token);
            $result = parent::get($key,$cache_cb,$cas_token);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getByKey( $server_key, $key, $cache_cb = null, &$cas_token = null ) {
            if (!$this->logging) return parent::getByKey($server_key,$key,$cache_cb,$cas_token);
            $start = microtime(true);
            $name = 'getByKey';
            $arguments = array($server_key,$key,$cache_cb,$cas_token);
            $result = parent::getByKey($server_key,$key,$cache_cb,$cas_token);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getMulti( array $keys, &$cas_tokens = null, $flags = 0 ) {
            if (!$this->logging) return parent::getMulti($keys,$cas_tokens,$flags);
            $start = microtime(true);
            $name = 'getMulti';
            $arguments = array($keys,$cas_tokens,$flags);
            $result = parent::getMulti($keys,$cas_tokens,$flags);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getMultiByKey( $server_key, array $keys, &$cas_tokens = null, $flags = 0 ) {
            if (!$this->logging) return parent::getMultiByKey($server_key,$keys,$cas_tokens,$flags);
            $start = microtime(true);
            $name = 'getMultiByKey';
            $arguments = array($server_key,$keys,$cas_tokens,$flags);
            $result = parent::getMultiByKey($server_key,$keys,$cas_tokens,$flags);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getDelayed( array $keys, $with_cas = null, $value_cb = null ) {
            if (!$this->logging) return parent::getDelayed($keys,$with_cas,$value_cb);
            $start = microtime(true);
            $name = 'getDelayed';
            $arguments = array($keys,$with_cas,$value_cb);
            $result = parent::getDelayed($keys,$with_cas,$value_cb);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getDelayedByKey( $server_key, array $keys, $with_cas = null, $value_cb = null ) {
            if (!$this->logging) return parent::getDelayedByKey($server_key,$keys,$with_cas,$value_cb);
            $start = microtime(true);
            $name = 'getDelayedByKey';
            $arguments = array($server_key,$keys,$with_cas,$value_cb);
            $result = parent::getDelayedByKey($server_key,$keys,$with_cas,$value_cb);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function fetch( ) {
            if (!$this->logging) return parent::fetch();
            $start = microtime(true);
            $name = 'fetch';
            $arguments = array();
            $result = parent::fetch();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function fetchAll( ) {
            if (!$this->logging) return parent::fetchAll();
            $start = microtime(true);
            $name = 'fetchAll';
            $arguments = array();
            $result = parent::fetchAll();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function set( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::set($key,$value,$expiration);
            $start = microtime(true);
            $name = 'set';
            $arguments = array($key,$value,$expiration);
            $result = parent::set($key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::setByKey($server_key,$key,$value,$expiration);
            $start = microtime(true);
            $name = 'setByKey';
            $arguments = array($server_key,$key,$value,$expiration);
            $result = parent::setByKey($server_key,$key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setMulti( array $items, $expiration = 0 ) {
            if (!$this->logging) return parent::setMulti($items,$expiration);
            $start = microtime(true);
            $name = 'setMulti';
            $arguments = array($items,$expiration);
            $result = parent::setMulti($items,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setMultiByKey( $server_key, array $items, $expiration = 0 ) {
            if (!$this->logging) return parent::setMultiByKey($server_key,$items,$expiration);
            $start = microtime(true);
            $name = 'setMultiByKey';
            $arguments = array($server_key,$items,$expiration);
            $result = parent::setMultiByKey($server_key,$items,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function cas( $token, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::cas($token,$key,$value,$expiration);
            $start = microtime(true);
            $name = 'cas';
            $arguments = array($token,$key,$value,$expiration);
            $result = parent::cas($token,$key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function casByKey( $token, $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::casByKey($token,$server_key,$key,$value,$expiration);
            $start = microtime(true);
            $name = 'casByKey';
            $arguments = array($token,$server_key,$key,$value,$expiration);
            $result = parent::casByKey($token,$server_key,$key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function add( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::add($key,$value,$expiration);
            $start = microtime(true);
            $name = 'add';
            $arguments = array($key,$value,$expiration);
            $result = parent::add($key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::addByKey($server_key,$key,$value,$expiration);
            $start = microtime(true);
            $name = 'addByKey';
            $arguments = array($server_key,$key,$value,$expiration);
            $result = parent::addByKey($server_key,$key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function append( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::append($key,$value,$expiration);
            $start = microtime(true);
            $name = 'append';
            $arguments = array($key,$value,$expiration);
            $result = parent::append($key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function appendByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::appendByKey($server_key,$key,$value,$expiration);
            $start = microtime(true);
            $name = 'appendByKey';
            $arguments = array($server_key,$key,$value,$expiration);
            $result = parent::appendByKey($server_key,$key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function prepend( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::prepend($key,$value,$expiration);
            $start = microtime(true);
            $name = 'prepend';
            $arguments = array($key,$value,$expiration);
            $result = parent::prepend($key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function prependByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::prependByKey($server_key,$key,$value,$expiration);
            $start = microtime(true);
            $name = 'prependByKey';
            $arguments = array($server_key,$key,$value,$expiration);
            $result = parent::prependByKey($server_key,$key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function replace( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::replace($key,$value,$expiration);
            $start = microtime(true);
            $name = 'replace';
            $arguments = array($key,$value,$expiration);
            $result = parent::replace($key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function replaceByKey( $serve_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::replaceByKey($serve_key,$key,$value,$expiration);
            $start = microtime(true);
            $name = 'replaceByKey';
            $arguments = array($serve_key,$key,$value,$expiration);
            $result = parent::replaceByKey($serve_key,$key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function delete( $key, $time = 0 ) {
            if (!$this->logging) return parent::delete($key,$time);
            $start = microtime(true);
            $name = 'delete';
            $arguments = array($key,$time);
            $result = parent::delete($key,$time);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function deleteByKey( $server_key, $key, $time = 0 ) {
            if (!$this->logging) return parent::deleteByKey($server_key,$key,$time);
            $start = microtime(true);
            $name = 'deleteByKey';
            $arguments = array($server_key,$key,$time);
            $result = parent::deleteByKey($server_key,$key,$time);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function increment( $key, $offset = 1) {
            if (!$this->logging) return parent::increment($key,$offset);
            $start = microtime(true);
            $name = 'increment';
            $arguments = array($key,$offset);
            $result = parent::increment($key,$offset);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function decrement( $key, $offset = 1) {
            if (!$this->logging) return parent::decrement($key,$offset);
            $start = microtime(true);
            $name = 'decrement';
            $arguments = array($key,$offset);
            $result = parent::decrement($key,$offset);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getOption( $option ) {
            if (!$this->logging) return parent::getOption($option);
            $start = microtime(true);
            $name = 'getOption';
            $arguments = array($option);
            $result = parent::getOption($option);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setOption( $option, $value ) {
            if (!$this->logging) return parent::setOption($option,$value);
            $start = microtime(true);
            $name = 'setOption';
            $arguments = array($option,$value);
            $result = parent::setOption($option,$value);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addServer( $host, $port,  $weight = 0 ) {
            if (!$this->logging) return parent::addServer($host,$port,$weight);
            $start = microtime(true);
            $name = 'addServer';
            $arguments = array($host,$port,$weight);
            $result = parent::addServer($host,$port,$weight);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addServers( array $servers ) {
            if (!$this->logging) return parent::addServers($servers);
            $start = microtime(true);
            $name = 'addServers';
            $arguments = array($servers);
            $result = parent::addServers($servers);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getServerList( ) {
            if (!$this->logging) return parent::getServerList();
            $start = microtime(true);
            $name = 'getServerList';
            $arguments = array();
            $result = parent::getServerList();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getServerByKey( $server_key ) {
            if (!$this->logging) return parent::getServerByKey($server_key);
            $start = microtime(true);
            $name = 'getServerByKey';
            $arguments = array($server_key);
            $result = parent::getServerByKey($server_key);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function flush( $delay = 0 ) {
            if (!$this->logging) return parent::flush($delay);
            $start = microtime(true);
            $name = 'flush';
            $arguments = array($delay);
            $result = parent::flush($delay);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getStats( ) {
            if (!$this->logging) return parent::getStats();
            $start = microtime(true);
            $name = 'getStats';
            $arguments = array();
            $result = parent::getStats();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getResultCode( ) {
            if (!$this->logging) return parent::getResultCode();
            $start = microtime(true);
            $name = 'getResultCode';
            $arguments = array();
            $result = parent::getResultCode();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getResultMessage( ) {
            if (!$this->logging) return parent::getResultMessage();
            $start = microtime(true);
            $name = 'getResultMessage';
            $arguments = array();
            $result = parent::getResultMessage();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
    }
} else if ($extension->getVersion()=='2.0.1') {
    class LoggingMemcache extends \Memcached implements MemcacheInterface, LoggingMemcacheInterface {
        public function __construct($logging, $persistent_id = '') {
            $this->calls = array();
            $this->logging = $logging;
            if ($persistent_id) {
                $this->initialize = count($this->getServerList())==0;
            } else {
                $this->initialize = true;
            }
            parent::__construct($persistent_id);
        }
        private $calls;
        private $initialize;
        private $logging;
        public function getLoggedCalls() {
            return $this->calls;
        }
        private function logCall($start, $result) {
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function get( $key, $cache_cb = null, &$cas_token = null ) {
            if (!$this->logging) return parent::get($key,$cache_cb,$cas_token);
            $start = microtime(true);
            $name = 'get';
            $arguments = array($key,$cache_cb,$cas_token);
            $result = parent::get($key,$cache_cb,$cas_token);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getByKey( $server_key, $key, $cache_cb = null, &$cas_token = null ) {
            if (!$this->logging) return parent::getByKey($server_key,$key,$cache_cb,$cas_token);
            $start = microtime(true);
            $name = 'getByKey';
            $arguments = array($server_key,$key,$cache_cb,$cas_token);
            $result = parent::getByKey($server_key,$key,$cache_cb,$cas_token);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getMulti( array $keys, &$cas_tokens = null, $flags = null ) {
            if (!$this->logging) return parent::getMulti($keys,$cas_tokens,$flags);
            $start = microtime(true);
            $name = 'getMulti';
            $arguments = array($keys,$cas_tokens,$flags);
            $result = parent::getMulti($keys,$cas_tokens,$flags);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getMultiByKey( $server_key, array $keys, &$cas_tokens = null, $flags = null ) {
            if (!$this->logging) return parent::getMultiByKey($server_key,$keys,$cas_tokens,$flags);
            $start = microtime(true);
            $name = 'getMultiByKey';
            $arguments = array($server_key,$keys,$cas_tokens,$flags);
            $result = parent::getMultiByKey($server_key,$keys,$cas_tokens,$flags);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getDelayed( array $keys, $with_cas = null, $value_cb = null ) {
            if (!$this->logging) return parent::getDelayed($keys,$with_cas,$value_cb);
            $start = microtime(true);
            $name = 'getDelayed';
            $arguments = array($keys,$with_cas,$value_cb);
            $result = parent::getDelayed($keys,$with_cas,$value_cb);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getDelayedByKey( $server_key, array $keys, $with_cas = null, $value_cb = null ) {
            if (!$this->logging) return parent::getDelayedByKey($server_key,$keys,$with_cas,$value_cb);
            $start = microtime(true);
            $name = 'getDelayedByKey';
            $arguments = array($server_key,$keys,$with_cas,$value_cb);
            $result = parent::getDelayedByKey($server_key,$keys,$with_cas,$value_cb);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function fetch( ) {
            if (!$this->logging) return parent::fetch();
            $start = microtime(true);
            $name = 'fetch';
            $arguments = array();
            $result = parent::fetch();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function fetchAll( ) {
            if (!$this->logging) return parent::fetchAll();
            $start = microtime(true);
            $name = 'fetchAll';
            $arguments = array();
            $result = parent::fetchAll();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function set( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::set($key,$value,$expiration);
            $start = microtime(true);
            $name = 'set';
            $arguments = array($key,$value,$expiration);
            $result = parent::set($key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function touch( $key, $expiration = 0 ) {
            if (!$this->logging) return parent::touch($key,$expiration);
            $start = microtime(true);
            $name = 'touch';
            $arguments = array($key,$expiration);
            $result = parent::touch($key,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function touchbyKey( $server_key, $key, $expiration = 0 ) {
            if (!$this->logging) return parent::touchbyKey($server_key,$key,$expiration);
            $start = microtime(true);
            $name = 'touchbyKey';
            $arguments = array($server_key,$key,$expiration);
            $result = parent::touchbyKey($server_key,$key,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::setByKey($server_key,$key,$value,$expiration);
            $start = microtime(true);
            $name = 'setByKey';
            $arguments = array($server_key,$key,$value,$expiration);
            $result = parent::setByKey($server_key,$key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setMulti( array $items, $expiration = 0 ) {
            if (!$this->logging) return parent::setMulti($items,$expiration);
            $start = microtime(true);
            $name = 'setMulti';
            $arguments = array($items,$expiration);
            $result = parent::setMulti($items,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setMultiByKey( $server_key, array $items, $expiration = 0 ) {
            if (!$this->logging) return parent::setMultiByKey($server_key,$items,$expiration);
            $start = microtime(true);
            $name = 'setMultiByKey';
            $arguments = array($server_key,$items,$expiration);
            $result = parent::setMultiByKey($server_key,$items,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function cas( $token, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::cas($token,$key,$value,$expiration);
            $start = microtime(true);
            $name = 'cas';
            $arguments = array($token,$key,$value,$expiration);
            $result = parent::cas($token,$key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function casByKey( $token, $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::casByKey($token,$server_key,$key,$value,$expiration);
            $start = microtime(true);
            $name = 'casByKey';
            $arguments = array($token,$server_key,$key,$value,$expiration);
            $result = parent::casByKey($token,$server_key,$key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function add( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::add($key,$value,$expiration);
            $start = microtime(true);
            $name = 'add';
            $arguments = array($key,$value,$expiration);
            $result = parent::add($key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::addByKey($server_key,$key,$value,$expiration);
            $start = microtime(true);
            $name = 'addByKey';
            $arguments = array($server_key,$key,$value,$expiration);
            $result = parent::addByKey($server_key,$key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function append( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::append($key,$value,$expiration);
            $start = microtime(true);
            $name = 'append';
            $arguments = array($key,$value,$expiration);
            $result = parent::append($key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function appendByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::appendByKey($server_key,$key,$value,$expiration);
            $start = microtime(true);
            $name = 'appendByKey';
            $arguments = array($server_key,$key,$value,$expiration);
            $result = parent::appendByKey($server_key,$key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function prepend( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::prepend($key,$value,$expiration);
            $start = microtime(true);
            $name = 'prepend';
            $arguments = array($key,$value,$expiration);
            $result = parent::prepend($key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function prependByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::prependByKey($server_key,$key,$value,$expiration);
            $start = microtime(true);
            $name = 'prependByKey';
            $arguments = array($server_key,$key,$value,$expiration);
            $result = parent::prependByKey($server_key,$key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function replace( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::replace($key,$value,$expiration);
            $start = microtime(true);
            $name = 'replace';
            $arguments = array($key,$value,$expiration);
            $result = parent::replace($key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function replaceByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::replaceByKey($server_key,$key,$value,$expiration);
            $start = microtime(true);
            $name = 'replaceByKey';
            $arguments = array($server_key,$key,$value,$expiration);
            $result = parent::replaceByKey($server_key,$key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function delete( $key, $time = 0 ) {
            if (!$this->logging) return parent::delete($key,$time);
            $start = microtime(true);
            $name = 'delete';
            $arguments = array($key,$time);
            $result = parent::delete($key,$time);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function deleteByKey( $server_key, $key, $time = 0 ) {
            if (!$this->logging) return parent::deleteByKey($server_key,$key,$time);
            $start = microtime(true);
            $name = 'deleteByKey';
            $arguments = array($server_key,$key,$time);
            $result = parent::deleteByKey($server_key,$key,$time);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function deleteMulti( $keys, $expiration = 0 ) {
            if (!$this->logging) return parent::deleteMulti($keys,$expiration);
            $start = microtime(true);
            $name = 'deleteMulti';
            $arguments = array($keys,$expiration);
            $result = parent::deleteMulti($keys,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function deleteMultiByKey( $server_key, $keys, $expiration = 0 ) {
            if (!$this->logging) return parent::deleteMultiByKey($server_key,$keys,$expiration);
            $start = microtime(true);
            $name = 'deleteMultiByKey';
            $arguments = array($server_key,$keys,$expiration);
            $result = parent::deleteMultiByKey($server_key,$keys,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function increment( $key, $offset = 1, $initial_value = 0, $expiry = 0 ) {
            if (!$this->logging) return parent::increment($key,$offset,$initial_value,$expiry);
            $start = microtime(true);
            $name = 'increment';
            $arguments = array($key,$offset,$initial_value,$expiry);
            $result = parent::increment($key,$offset,$initial_value,$expiry);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function incrementByKey( $server_key, $key, $offset = 1, $initial_value = 0, $expiry = 0 ) {
            if (!$this->logging) return parent::incrementByKey($server_key,$key,$offset,$initial_value,$expiry);
            $start = microtime(true);
            $name = 'incrementByKey';
            $arguments = array($server_key,$key,$offset,$initial_value,$expiry);
            $result = parent::incrementByKey($server_key,$key,$offset,$initial_value,$expiry);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function decrement( $key, $offset = 1, $initial_value = 0, $expiry = 0 ) {
            if (!$this->logging) return parent::decrement($key,$offset,$initial_value,$expiry);
            $start = microtime(true);
            $name = 'decrement';
            $arguments = array($key,$offset,$initial_value,$expiry);
            $result = parent::decrement($key,$offset,$initial_value,$expiry);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function decrementByKey( $server_key, $key, $offset = 1, $initial_value = 0, $expiry = 0 ) {
            if (!$this->logging) return parent::decrementByKey($server_key,$key,$offset,$initial_value,$expiry);
            $start = microtime(true);
            $name = 'decrementByKey';
            $arguments = array($server_key,$key,$offset,$initial_value,$expiry);
            $result = parent::decrementByKey($server_key,$key,$offset,$initial_value,$expiry);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getOption( $option ) {
            if (!$this->logging) return parent::getOption($option);
            $start = microtime(true);
            $name = 'getOption';
            $arguments = array($option);
            $result = parent::getOption($option);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setOption( $option, $value ) {
            if (!$this->logging) return parent::setOption($option,$value);
            $start = microtime(true);
            $name = 'setOption';
            $arguments = array($option,$value);
            $result = parent::setOption($option,$value);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setOptions( $options ) {
            if (!$this->logging) return parent::setOptions($options);
            $start = microtime(true);
            $name = 'setOptions';
            $arguments = array($options);
            $result = parent::setOptions($options);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addServer( $host, $port,  $weight = 0 ) {
            if (!$this->logging) return parent::addServer($host,$port,$weight);
            $start = microtime(true);
            $name = 'addServer';
            $arguments = array($host,$port,$weight);
            $result = parent::addServer($host,$port,$weight);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addServers( array $servers ) {
            if (!$this->logging) return parent::addServers($servers);
            $start = microtime(true);
            $name = 'addServers';
            $arguments = array($servers);
            $result = parent::addServers($servers);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getServerList( ) {
            if (!$this->logging) return parent::getServerList();
            $start = microtime(true);
            $name = 'getServerList';
            $arguments = array();
            $result = parent::getServerList();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getServerByKey( $server_key ) {
            if (!$this->logging) return parent::getServerByKey($server_key);
            $start = microtime(true);
            $name = 'getServerByKey';
            $arguments = array($server_key);
            $result = parent::getServerByKey($server_key);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function flush( $delay = 0 ) {
            if (!$this->logging) return parent::flush($delay);
            $start = microtime(true);
            $name = 'flush';
            $arguments = array($delay);
            $result = parent::flush($delay);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getStats( ) {
            if (!$this->logging) return parent::getStats();
            $start = microtime(true);
            $name = 'getStats';
            $arguments = array();
            $result = parent::getStats();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getVersion( ) {
            if (!$this->logging) return parent::getVersion();
            $start = microtime(true);
            $name = 'getVersion';
            $arguments = array();
            $result = parent::getVersion();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getResultCode( ) {
            if (!$this->logging) return parent::getResultCode();
            $start = microtime(true);
            $name = 'getResultCode';
            $arguments = array();
            $result = parent::getResultCode();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getResultMessage( ) {
            if (!$this->logging) return parent::getResultMessage();
            $start = microtime(true);
            $name = 'getResultMessage';
            $arguments = array();
            $result = parent::getResultMessage();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function isPersistent( ) {
            if (!$this->logging) return parent::isPersistent();
            $start = microtime(true);
            $name = 'isPersistent';
            $arguments = array();
            $result = parent::isPersistent();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function isPristine( ) {
            if (!$this->logging) return parent::isPristine();
            $start = microtime(true);
            $name = 'isPristine';
            $arguments = array();
            $result = parent::isPristine();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
    }
} else if ($extension->getVersion()=='2.1.0') {
    class LoggingMemcache extends \Memcached implements MemcacheInterface, LoggingMemcacheInterface {
        public function __construct($logging, $persistent_id = '') {
            $this->calls = array();
            $this->logging = $logging;
            if ($persistent_id) {
                $this->initialize = count($this->getServerList())==0;
            } else {
                $this->initialize = true;
            }
            parent::__construct($persistent_id);
        }
        private $calls;
        private $initialize;
        private $logging;
        public function getLoggedCalls() {
            return $this->calls;
        }
        private function logCall($start, $result) {
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function get( $key, $cache_cb = null, &$cas_token = null ) {
            if (!$this->logging) return parent::get($key,$cache_cb,$cas_token);
            $start = microtime(true);
            $name = 'get';
            $arguments = array($key,$cache_cb,$cas_token);
            $result = parent::get($key,$cache_cb,$cas_token);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getByKey( $server_key, $key, $cache_cb = null, &$cas_token = null ) {
            if (!$this->logging) return parent::getByKey($server_key,$key,$cache_cb,$cas_token);
            $start = microtime(true);
            $name = 'getByKey';
            $arguments = array($server_key,$key,$cache_cb,$cas_token);
            $result = parent::getByKey($server_key,$key,$cache_cb,$cas_token);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getMulti( array $keys, &$cas_tokens = null, $flags = null ) {
            if (!$this->logging) return parent::getMulti($keys,$cas_tokens,$flags);
            $start = microtime(true);
            $name = 'getMulti';
            $arguments = array($keys,$cas_tokens,$flags);
            $result = parent::getMulti($keys,$cas_tokens,$flags);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getMultiByKey( $server_key, array $keys, &$cas_tokens = null, $flags = null ) {
            if (!$this->logging) return parent::getMultiByKey($server_key,$keys,$cas_tokens,$flags);
            $start = microtime(true);
            $name = 'getMultiByKey';
            $arguments = array($server_key,$keys,$cas_tokens,$flags);
            $result = parent::getMultiByKey($server_key,$keys,$cas_tokens,$flags);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getDelayed( array $keys, $with_cas = null, $value_cb = null ) {
            if (!$this->logging) return parent::getDelayed($keys,$with_cas,$value_cb);
            $start = microtime(true);
            $name = 'getDelayed';
            $arguments = array($keys,$with_cas,$value_cb);
            $result = parent::getDelayed($keys,$with_cas,$value_cb);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getDelayedByKey( $server_key, array $keys, $with_cas = null, $value_cb = null ) {
            if (!$this->logging) return parent::getDelayedByKey($server_key,$keys,$with_cas,$value_cb);
            $start = microtime(true);
            $name = 'getDelayedByKey';
            $arguments = array($server_key,$keys,$with_cas,$value_cb);
            $result = parent::getDelayedByKey($server_key,$keys,$with_cas,$value_cb);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function fetch( ) {
            if (!$this->logging) return parent::fetch();
            $start = microtime(true);
            $name = 'fetch';
            $arguments = array();
            $result = parent::fetch();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function fetchAll( ) {
            if (!$this->logging) return parent::fetchAll();
            $start = microtime(true);
            $name = 'fetchAll';
            $arguments = array();
            $result = parent::fetchAll();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function set( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::set($key,$value,$expiration);
            $start = microtime(true);
            $name = 'set';
            $arguments = array($key,$value,$expiration);
            $result = parent::set($key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function touch( $key, $expiration = 0 ) {
            if (!$this->logging) return parent::touch($key,$expiration);
            $start = microtime(true);
            $name = 'touch';
            $arguments = array($key,$expiration);
            $result = parent::touch($key,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function touchbyKey( $server_key, $key, $expiration = 0 ) {
            if (!$this->logging) return parent::touchbyKey($server_key,$key,$expiration);
            $start = microtime(true);
            $name = 'touchbyKey';
            $arguments = array($server_key,$key,$expiration);
            $result = parent::touchbyKey($server_key,$key,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::setByKey($server_key,$key,$value,$expiration);
            $start = microtime(true);
            $name = 'setByKey';
            $arguments = array($server_key,$key,$value,$expiration);
            $result = parent::setByKey($server_key,$key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setMulti( array $items, $expiration = 0 ) {
            if (!$this->logging) return parent::setMulti($items,$expiration);
            $start = microtime(true);
            $name = 'setMulti';
            $arguments = array($items,$expiration);
            $result = parent::setMulti($items,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setMultiByKey( $server_key, array $items, $expiration = 0 ) {
            if (!$this->logging) return parent::setMultiByKey($server_key,$items,$expiration);
            $start = microtime(true);
            $name = 'setMultiByKey';
            $arguments = array($server_key,$items,$expiration);
            $result = parent::setMultiByKey($server_key,$items,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function cas( $token, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::cas($token,$key,$value,$expiration);
            $start = microtime(true);
            $name = 'cas';
            $arguments = array($token,$key,$value,$expiration);
            $result = parent::cas($token,$key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function casByKey( $token, $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::casByKey($token,$server_key,$key,$value,$expiration);
            $start = microtime(true);
            $name = 'casByKey';
            $arguments = array($token,$server_key,$key,$value,$expiration);
            $result = parent::casByKey($token,$server_key,$key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function add( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::add($key,$value,$expiration);
            $start = microtime(true);
            $name = 'add';
            $arguments = array($key,$value,$expiration);
            $result = parent::add($key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::addByKey($server_key,$key,$value,$expiration);
            $start = microtime(true);
            $name = 'addByKey';
            $arguments = array($server_key,$key,$value,$expiration);
            $result = parent::addByKey($server_key,$key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function append( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::append($key,$value,$expiration);
            $start = microtime(true);
            $name = 'append';
            $arguments = array($key,$value,$expiration);
            $result = parent::append($key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function appendByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::appendByKey($server_key,$key,$value,$expiration);
            $start = microtime(true);
            $name = 'appendByKey';
            $arguments = array($server_key,$key,$value,$expiration);
            $result = parent::appendByKey($server_key,$key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function prepend( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::prepend($key,$value,$expiration);
            $start = microtime(true);
            $name = 'prepend';
            $arguments = array($key,$value,$expiration);
            $result = parent::prepend($key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function prependByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::prependByKey($server_key,$key,$value,$expiration);
            $start = microtime(true);
            $name = 'prependByKey';
            $arguments = array($server_key,$key,$value,$expiration);
            $result = parent::prependByKey($server_key,$key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function replace( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::replace($key,$value,$expiration);
            $start = microtime(true);
            $name = 'replace';
            $arguments = array($key,$value,$expiration);
            $result = parent::replace($key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function replaceByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::replaceByKey($server_key,$key,$value,$expiration);
            $start = microtime(true);
            $name = 'replaceByKey';
            $arguments = array($server_key,$key,$value,$expiration);
            $result = parent::replaceByKey($server_key,$key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function delete( $key, $time = 0 ) {
            if (!$this->logging) return parent::delete($key,$time);
            $start = microtime(true);
            $name = 'delete';
            $arguments = array($key,$time);
            $result = parent::delete($key,$time);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function deleteByKey( $server_key, $key, $time = 0 ) {
            if (!$this->logging) return parent::deleteByKey($server_key,$key,$time);
            $start = microtime(true);
            $name = 'deleteByKey';
            $arguments = array($server_key,$key,$time);
            $result = parent::deleteByKey($server_key,$key,$time);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function deleteMulti( $keys, $expiration = 0 ) {
            if (!$this->logging) return parent::deleteMulti($keys,$expiration);
            $start = microtime(true);
            $name = 'deleteMulti';
            $arguments = array($keys,$expiration);
            $result = parent::deleteMulti($keys,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function deleteMultiByKey( $server_key, $keys, $expiration = 0 ) {
            if (!$this->logging) return parent::deleteMultiByKey($server_key,$keys,$expiration);
            $start = microtime(true);
            $name = 'deleteMultiByKey';
            $arguments = array($server_key,$keys,$expiration);
            $result = parent::deleteMultiByKey($server_key,$keys,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function increment( $key, $offset = 1, $initial_value = 0, $expiry = 0 ) {
            if (!$this->logging) return parent::increment($key,$offset,$initial_value,$expiry);
            $start = microtime(true);
            $name = 'increment';
            $arguments = array($key,$offset,$initial_value,$expiry);
            $result = parent::increment($key,$offset,$initial_value,$expiry);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function incrementByKey( $server_key, $key, $offset = 1, $initial_value = 0, $expiry = 0 ) {
            if (!$this->logging) return parent::incrementByKey($server_key,$key,$offset,$initial_value,$expiry);
            $start = microtime(true);
            $name = 'incrementByKey';
            $arguments = array($server_key,$key,$offset,$initial_value,$expiry);
            $result = parent::incrementByKey($server_key,$key,$offset,$initial_value,$expiry);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function decrement( $key, $offset = 1, $initial_value = 0, $expiry = 0 ) {
            if (!$this->logging) return parent::decrement($key,$offset,$initial_value,$expiry);
            $start = microtime(true);
            $name = 'decrement';
            $arguments = array($key,$offset,$initial_value,$expiry);
            $result = parent::decrement($key,$offset,$initial_value,$expiry);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function decrementByKey( $server_key, $key, $offset = 1, $initial_value = 0, $expiry = 0 ) {
            if (!$this->logging) return parent::decrementByKey($server_key,$key,$offset,$initial_value,$expiry);
            $start = microtime(true);
            $name = 'decrementByKey';
            $arguments = array($server_key,$key,$offset,$initial_value,$expiry);
            $result = parent::decrementByKey($server_key,$key,$offset,$initial_value,$expiry);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getOption( $option ) {
            if (!$this->logging) return parent::getOption($option);
            $start = microtime(true);
            $name = 'getOption';
            $arguments = array($option);
            $result = parent::getOption($option);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setOption( $option, $value ) {
            if (!$this->logging) return parent::setOption($option,$value);
            $start = microtime(true);
            $name = 'setOption';
            $arguments = array($option,$value);
            $result = parent::setOption($option,$value);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setOptions( $options ) {
            if (!$this->logging) return parent::setOptions($options);
            $start = microtime(true);
            $name = 'setOptions';
            $arguments = array($options);
            $result = parent::setOptions($options);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addServer( $host, $port,  $weight = 0 ) {
            if (!$this->logging) return parent::addServer($host,$port,$weight);
            $start = microtime(true);
            $name = 'addServer';
            $arguments = array($host,$port,$weight);
            $result = parent::addServer($host,$port,$weight);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addServers( array $servers ) {
            if (!$this->logging) return parent::addServers($servers);
            $start = microtime(true);
            $name = 'addServers';
            $arguments = array($servers);
            $result = parent::addServers($servers);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getServerList( ) {
            if (!$this->logging) return parent::getServerList();
            $start = microtime(true);
            $name = 'getServerList';
            $arguments = array();
            $result = parent::getServerList();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getServerByKey( $server_key ) {
            if (!$this->logging) return parent::getServerByKey($server_key);
            $start = microtime(true);
            $name = 'getServerByKey';
            $arguments = array($server_key);
            $result = parent::getServerByKey($server_key);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function flush( $delay = 0 ) {
            if (!$this->logging) return parent::flush($delay);
            $start = microtime(true);
            $name = 'flush';
            $arguments = array($delay);
            $result = parent::flush($delay);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getStats( ) {
            if (!$this->logging) return parent::getStats();
            $start = microtime(true);
            $name = 'getStats';
            $arguments = array();
            $result = parent::getStats();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getVersion( ) {
            if (!$this->logging) return parent::getVersion();
            $start = microtime(true);
            $name = 'getVersion';
            $arguments = array();
            $result = parent::getVersion();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getResultCode( ) {
            if (!$this->logging) return parent::getResultCode();
            $start = microtime(true);
            $name = 'getResultCode';
            $arguments = array();
            $result = parent::getResultCode();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getResultMessage( ) {
            if (!$this->logging) return parent::getResultMessage();
            $start = microtime(true);
            $name = 'getResultMessage';
            $arguments = array();
            $result = parent::getResultMessage();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function isPersistent( ) {
            if (!$this->logging) return parent::isPersistent();
            $start = microtime(true);
            $name = 'isPersistent';
            $arguments = array();
            $result = parent::isPersistent();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function isPristine( ) {
            if (!$this->logging) return parent::isPristine();
            $start = microtime(true);
            $name = 'isPristine';
            $arguments = array();
            $result = parent::isPristine();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
    }
} else if ($extension->getVersion()=='2.2.0') {
    class LoggingMemcache extends \Memcached implements MemcacheInterface, LoggingMemcacheInterface {
        public function __construct($logging, $persistent_id = '') {
            $this->calls = array();
            $this->logging = $logging;
            if ($persistent_id) {
                $this->initialize = count($this->getServerList())==0;
            } else {
                $this->initialize = true;
            }
            parent::__construct($persistent_id);
        }
        private $calls;
        private $initialize;
        private $logging;
        public function getLoggedCalls() {
            return $this->calls;
        }
        private function logCall($start, $result) {
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function get( $key, $cache_cb = null, &$cas_token = null, &$udf_flags = null ) {
            if (!$this->logging) return parent::get($key,$cache_cb,$cas_token,$udf_flags);
            $start = microtime(true);
            $name = 'get';
            $arguments = array($key,$cache_cb,$cas_token,$udf_flags);
            $result = parent::get($key,$cache_cb,$cas_token,$udf_flags);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getByKey( $server_key, $key, $cache_cb = null, &$cas_token = null, &$udf_flags = null ) {
            if (!$this->logging) return parent::getByKey($server_key,$key,$cache_cb,$cas_token,$udf_flags);
            $start = microtime(true);
            $name = 'getByKey';
            $arguments = array($server_key,$key,$cache_cb,$cas_token,$udf_flags);
            $result = parent::getByKey($server_key,$key,$cache_cb,$cas_token,$udf_flags);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getMulti( array $keys, &$cas_tokens = null, $flags = null, &$udf_flags = null ) {
            if (!$this->logging) return parent::getMulti($keys,$cas_tokens,$flags,$udf_flags);
            $start = microtime(true);
            $name = 'getMulti';
            $arguments = array($keys,$cas_tokens,$flags,$udf_flags);
            $result = parent::getMulti($keys,$cas_tokens,$flags,$udf_flags);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getMultiByKey( $server_key, array $keys, &$cas_tokens = null, $flags = null, &$udf_flags = null ) {
            if (!$this->logging) return parent::getMultiByKey($server_key,$keys,$cas_tokens,$flags,$udf_flags);
            $start = microtime(true);
            $name = 'getMultiByKey';
            $arguments = array($server_key,$keys,$cas_tokens,$flags,$udf_flags);
            $result = parent::getMultiByKey($server_key,$keys,$cas_tokens,$flags,$udf_flags);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getDelayed( array $keys, $with_cas = null, $value_cb = null ) {
            if (!$this->logging) return parent::getDelayed($keys,$with_cas,$value_cb);
            $start = microtime(true);
            $name = 'getDelayed';
            $arguments = array($keys,$with_cas,$value_cb);
            $result = parent::getDelayed($keys,$with_cas,$value_cb);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getDelayedByKey( $server_key, array $keys, $with_cas = null, $value_cb = null ) {
            if (!$this->logging) return parent::getDelayedByKey($server_key,$keys,$with_cas,$value_cb);
            $start = microtime(true);
            $name = 'getDelayedByKey';
            $arguments = array($server_key,$keys,$with_cas,$value_cb);
            $result = parent::getDelayedByKey($server_key,$keys,$with_cas,$value_cb);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function fetch( ) {
            if (!$this->logging) return parent::fetch();
            $start = microtime(true);
            $name = 'fetch';
            $arguments = array();
            $result = parent::fetch();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function fetchAll( ) {
            if (!$this->logging) return parent::fetchAll();
            $start = microtime(true);
            $name = 'fetchAll';
            $arguments = array();
            $result = parent::fetchAll();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function set( $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return parent::set($key,$value,$expiration,$udf_flags);
            $start = microtime(true);
            $name = 'set';
            $arguments = array($key,$value,$expiration,$udf_flags);
            $result = parent::set($key,$value,$expiration,$udf_flags);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function touch( $key, $expiration = 0 ) {
            if (!$this->logging) return parent::touch($key,$expiration);
            $start = microtime(true);
            $name = 'touch';
            $arguments = array($key,$expiration);
            $result = parent::touch($key,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function touchbyKey( $server_key, $key, $expiration = 0 ) {
            if (!$this->logging) return parent::touchbyKey($server_key,$key,$expiration);
            $start = microtime(true);
            $name = 'touchbyKey';
            $arguments = array($server_key,$key,$expiration);
            $result = parent::touchbyKey($server_key,$key,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setByKey( $server_key, $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return parent::setByKey($server_key,$key,$value,$expiration,$udf_flags);
            $start = microtime(true);
            $name = 'setByKey';
            $arguments = array($server_key,$key,$value,$expiration,$udf_flags);
            $result = parent::setByKey($server_key,$key,$value,$expiration,$udf_flags);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setMulti( array $items, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return parent::setMulti($items,$expiration,$udf_flags);
            $start = microtime(true);
            $name = 'setMulti';
            $arguments = array($items,$expiration,$udf_flags);
            $result = parent::setMulti($items,$expiration,$udf_flags);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setMultiByKey( $server_key, array $items, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return parent::setMultiByKey($server_key,$items,$expiration,$udf_flags);
            $start = microtime(true);
            $name = 'setMultiByKey';
            $arguments = array($server_key,$items,$expiration,$udf_flags);
            $result = parent::setMultiByKey($server_key,$items,$expiration,$udf_flags);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function cas( $token, $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return parent::cas($token,$key,$value,$expiration,$udf_flags);
            $start = microtime(true);
            $name = 'cas';
            $arguments = array($token,$key,$value,$expiration,$udf_flags);
            $result = parent::cas($token,$key,$value,$expiration,$udf_flags);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function casByKey( $token, $server_key, $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return parent::casByKey($token,$server_key,$key,$value,$expiration,$udf_flags);
            $start = microtime(true);
            $name = 'casByKey';
            $arguments = array($token,$server_key,$key,$value,$expiration,$udf_flags);
            $result = parent::casByKey($token,$server_key,$key,$value,$expiration,$udf_flags);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function add( $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return parent::add($key,$value,$expiration,$udf_flags);
            $start = microtime(true);
            $name = 'add';
            $arguments = array($key,$value,$expiration,$udf_flags);
            $result = parent::add($key,$value,$expiration,$udf_flags);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addByKey( $server_key, $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return parent::addByKey($server_key,$key,$value,$expiration,$udf_flags);
            $start = microtime(true);
            $name = 'addByKey';
            $arguments = array($server_key,$key,$value,$expiration,$udf_flags);
            $result = parent::addByKey($server_key,$key,$value,$expiration,$udf_flags);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function append( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::append($key,$value,$expiration);
            $start = microtime(true);
            $name = 'append';
            $arguments = array($key,$value,$expiration);
            $result = parent::append($key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function appendByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::appendByKey($server_key,$key,$value,$expiration);
            $start = microtime(true);
            $name = 'appendByKey';
            $arguments = array($server_key,$key,$value,$expiration);
            $result = parent::appendByKey($server_key,$key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function prepend( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::prepend($key,$value,$expiration);
            $start = microtime(true);
            $name = 'prepend';
            $arguments = array($key,$value,$expiration);
            $result = parent::prepend($key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function prependByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::prependByKey($server_key,$key,$value,$expiration);
            $start = microtime(true);
            $name = 'prependByKey';
            $arguments = array($server_key,$key,$value,$expiration);
            $result = parent::prependByKey($server_key,$key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function replace( $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return parent::replace($key,$value,$expiration,$udf_flags);
            $start = microtime(true);
            $name = 'replace';
            $arguments = array($key,$value,$expiration,$udf_flags);
            $result = parent::replace($key,$value,$expiration,$udf_flags);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function replaceByKey( $server_key, $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return parent::replaceByKey($server_key,$key,$value,$expiration,$udf_flags);
            $start = microtime(true);
            $name = 'replaceByKey';
            $arguments = array($server_key,$key,$value,$expiration,$udf_flags);
            $result = parent::replaceByKey($server_key,$key,$value,$expiration,$udf_flags);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function delete( $key, $time = 0 ) {
            if (!$this->logging) return parent::delete($key,$time);
            $start = microtime(true);
            $name = 'delete';
            $arguments = array($key,$time);
            $result = parent::delete($key,$time);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function deleteByKey( $server_key, $key, $time = 0 ) {
            if (!$this->logging) return parent::deleteByKey($server_key,$key,$time);
            $start = microtime(true);
            $name = 'deleteByKey';
            $arguments = array($server_key,$key,$time);
            $result = parent::deleteByKey($server_key,$key,$time);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function deleteMulti( $keys, $expiration = 0 ) {
            if (!$this->logging) return parent::deleteMulti($keys,$expiration);
            $start = microtime(true);
            $name = 'deleteMulti';
            $arguments = array($keys,$expiration);
            $result = parent::deleteMulti($keys,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function deleteMultiByKey( $server_key, $keys, $expiration = 0 ) {
            if (!$this->logging) return parent::deleteMultiByKey($server_key,$keys,$expiration);
            $start = microtime(true);
            $name = 'deleteMultiByKey';
            $arguments = array($server_key,$keys,$expiration);
            $result = parent::deleteMultiByKey($server_key,$keys,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function increment( $key, $offset = 1, $initial_value = 0, $expiry = 0) {
            if (!$this->logging) return parent::increment($key,$offset,$initial_value,$expiry);
            $start = microtime(true);
            $name = 'increment';
            $arguments = array($key,$offset,$initial_value,$expiry);
            $result = parent::increment($key,$offset,$initial_value,$expiry);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function incrementByKey( $server_key, $key, $offset = 1, $initial_value = 0, $expiry = 0 ) {
            if (!$this->logging) return parent::incrementByKey($server_key,$key,$offset,$initial_value,$expiry);
            $start = microtime(true);
            $name = 'incrementByKey';
            $arguments = array($server_key,$key,$offset,$initial_value,$expiry);
            $result = parent::incrementByKey($server_key,$key,$offset,$initial_value,$expiry);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function decrement( $key, $offset = 1, $initial_value = 0, $expiry = 0) {
            if (!$this->logging) return parent::decrement($key,$offset,$initial_value,$expiry);
            $start = microtime(true);
            $name = 'decrement';
            $arguments = array($key,$offset,$initial_value,$expiry);
            $result = parent::decrement($key,$offset,$initial_value,$expiry);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function decrementByKey( $server_key, $key, $offset = 1, $initial_value = 0, $expiry = 0 ) {
            if (!$this->logging) return parent::decrementByKey($server_key,$key,$offset,$initial_value,$expiry);
            $start = microtime(true);
            $name = 'decrementByKey';
            $arguments = array($server_key,$key,$offset,$initial_value,$expiry);
            $result = parent::decrementByKey($server_key,$key,$offset,$initial_value,$expiry);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getOption( $option ) {
            if (!$this->logging) return parent::getOption($option);
            $start = microtime(true);
            $name = 'getOption';
            $arguments = array($option);
            $result = parent::getOption($option);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setOption( $option, $value ) {
            if (!$this->logging) return parent::setOption($option,$value);
            $start = microtime(true);
            $name = 'setOption';
            $arguments = array($option,$value);
            $result = parent::setOption($option,$value);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setOptions( $options ) {
            if (!$this->logging) return parent::setOptions($options);
            $start = microtime(true);
            $name = 'setOptions';
            $arguments = array($options);
            $result = parent::setOptions($options);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setBucket( $host_map, $forward_map, $replicas ) {
            if (!$this->logging) return parent::setBucket($host_map,$forward_map,$replicas);
            $start = microtime(true);
            $name = 'setBucket';
            $arguments = array($host_map,$forward_map,$replicas);
            $result = parent::setBucket($host_map,$forward_map,$replicas);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addServer( $host, $port,  $weight = 0 ) {
            if (!$this->logging) return parent::addServer($host,$port,$weight);
            $start = microtime(true);
            $name = 'addServer';
            $arguments = array($host,$port,$weight);
            $result = parent::addServer($host,$port,$weight);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addServers( array $servers ) {
            if (!$this->logging) return parent::addServers($servers);
            $start = microtime(true);
            $name = 'addServers';
            $arguments = array($servers);
            $result = parent::addServers($servers);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getServerList( ) {
            if (!$this->logging) return parent::getServerList();
            $start = microtime(true);
            $name = 'getServerList';
            $arguments = array();
            $result = parent::getServerList();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getServerByKey( $server_key ) {
            if (!$this->logging) return parent::getServerByKey($server_key);
            $start = microtime(true);
            $name = 'getServerByKey';
            $arguments = array($server_key);
            $result = parent::getServerByKey($server_key);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getLastErrorMessage( ) {
            if (!$this->logging) return parent::getLastErrorMessage();
            $start = microtime(true);
            $name = 'getLastErrorMessage';
            $arguments = array();
            $result = parent::getLastErrorMessage();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getLastErrorCode( ) {
            if (!$this->logging) return parent::getLastErrorCode();
            $start = microtime(true);
            $name = 'getLastErrorCode';
            $arguments = array();
            $result = parent::getLastErrorCode();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getLastErrorErrno( ) {
            if (!$this->logging) return parent::getLastErrorErrno();
            $start = microtime(true);
            $name = 'getLastErrorErrno';
            $arguments = array();
            $result = parent::getLastErrorErrno();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getLastDisconnectedServer( ) {
            if (!$this->logging) return parent::getLastDisconnectedServer();
            $start = microtime(true);
            $name = 'getLastDisconnectedServer';
            $arguments = array();
            $result = parent::getLastDisconnectedServer();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function flush( $delay = 0 ) {
            if (!$this->logging) return parent::flush($delay);
            $start = microtime(true);
            $name = 'flush';
            $arguments = array($delay);
            $result = parent::flush($delay);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getStats( ) {
            if (!$this->logging) return parent::getStats();
            $start = microtime(true);
            $name = 'getStats';
            $arguments = array();
            $result = parent::getStats();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getVersion( ) {
            if (!$this->logging) return parent::getVersion();
            $start = microtime(true);
            $name = 'getVersion';
            $arguments = array();
            $result = parent::getVersion();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getResultCode( ) {
            if (!$this->logging) return parent::getResultCode();
            $start = microtime(true);
            $name = 'getResultCode';
            $arguments = array();
            $result = parent::getResultCode();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getResultMessage( ) {
            if (!$this->logging) return parent::getResultMessage();
            $start = microtime(true);
            $name = 'getResultMessage';
            $arguments = array();
            $result = parent::getResultMessage();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function isPersistent( ) {
            if (!$this->logging) return parent::isPersistent();
            $start = microtime(true);
            $name = 'isPersistent';
            $arguments = array();
            $result = parent::isPersistent();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function isPristine( ) {
            if (!$this->logging) return parent::isPristine();
            $start = microtime(true);
            $name = 'isPristine';
            $arguments = array();
            $result = parent::isPristine();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setSaslAuthData( $username, $password ) {
            if (!$this->logging) return parent::setSaslAuthData($username,$password);
            $start = microtime(true);
            $name = 'setSaslAuthData';
            $arguments = array($username,$password);
            $result = parent::setSaslAuthData($username,$password);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
    }
} else if ($extension->getVersion()=='2.2.0b1') {
    class LoggingMemcache extends \Memcached implements MemcacheInterface, LoggingMemcacheInterface {
        public function __construct($logging, $persistent_id = '') {
            $this->calls = array();
            $this->logging = $logging;
            if ($persistent_id) {
                $this->initialize = count($this->getServerList())==0;
            } else {
                $this->initialize = true;
            }
            parent::__construct($persistent_id);
        }
        private $calls;
        private $initialize;
        private $logging;
        public function getLoggedCalls() {
            return $this->calls;
        }
        private function logCall($start, $result) {
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function get( $key, $cache_cb = null, &$cas_token = null, &$udf_flags = null ) {
            if (!$this->logging) return parent::get($key,$cache_cb,$cas_token,$udf_flags);
            $start = microtime(true);
            $name = 'get';
            $arguments = array($key,$cache_cb,$cas_token,$udf_flags);
            $result = parent::get($key,$cache_cb,$cas_token,$udf_flags);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getByKey( $server_key, $key, $cache_cb = null, &$cas_token = null, &$udf_flags = null ) {
            if (!$this->logging) return parent::getByKey($server_key,$key,$cache_cb,$cas_token,$udf_flags);
            $start = microtime(true);
            $name = 'getByKey';
            $arguments = array($server_key,$key,$cache_cb,$cas_token,$udf_flags);
            $result = parent::getByKey($server_key,$key,$cache_cb,$cas_token,$udf_flags);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getMulti( array $keys, &$cas_tokens = null, $flags = null, &$udf_flags = null ) {
            if (!$this->logging) return parent::getMulti($keys,$cas_tokens,$flags,$udf_flags);
            $start = microtime(true);
            $name = 'getMulti';
            $arguments = array($keys,$cas_tokens,$flags,$udf_flags);
            $result = parent::getMulti($keys,$cas_tokens,$flags,$udf_flags);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getMultiByKey( $server_key, array $keys, &$cas_tokens = null, $flags = null, &$udf_flags = null ) {
            if (!$this->logging) return parent::getMultiByKey($server_key,$keys,$cas_tokens,$flags,$udf_flags);
            $start = microtime(true);
            $name = 'getMultiByKey';
            $arguments = array($server_key,$keys,$cas_tokens,$flags,$udf_flags);
            $result = parent::getMultiByKey($server_key,$keys,$cas_tokens,$flags,$udf_flags);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getDelayed( array $keys, $with_cas = null, $value_cb = null ) {
            if (!$this->logging) return parent::getDelayed($keys,$with_cas,$value_cb);
            $start = microtime(true);
            $name = 'getDelayed';
            $arguments = array($keys,$with_cas,$value_cb);
            $result = parent::getDelayed($keys,$with_cas,$value_cb);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getDelayedByKey( $server_key, array $keys, $with_cas = null, $value_cb = null ) {
            if (!$this->logging) return parent::getDelayedByKey($server_key,$keys,$with_cas,$value_cb);
            $start = microtime(true);
            $name = 'getDelayedByKey';
            $arguments = array($server_key,$keys,$with_cas,$value_cb);
            $result = parent::getDelayedByKey($server_key,$keys,$with_cas,$value_cb);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function fetch( ) {
            if (!$this->logging) return parent::fetch();
            $start = microtime(true);
            $name = 'fetch';
            $arguments = array();
            $result = parent::fetch();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function fetchAll( ) {
            if (!$this->logging) return parent::fetchAll();
            $start = microtime(true);
            $name = 'fetchAll';
            $arguments = array();
            $result = parent::fetchAll();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function set( $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return parent::set($key,$value,$expiration,$udf_flags);
            $start = microtime(true);
            $name = 'set';
            $arguments = array($key,$value,$expiration,$udf_flags);
            $result = parent::set($key,$value,$expiration,$udf_flags);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function touch( $key, $expiration = 0 ) {
            if (!$this->logging) return parent::touch($key,$expiration);
            $start = microtime(true);
            $name = 'touch';
            $arguments = array($key,$expiration);
            $result = parent::touch($key,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function touchbyKey( $server_key, $key, $expiration = 0 ) {
            if (!$this->logging) return parent::touchbyKey($server_key,$key,$expiration);
            $start = microtime(true);
            $name = 'touchbyKey';
            $arguments = array($server_key,$key,$expiration);
            $result = parent::touchbyKey($server_key,$key,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setByKey( $server_key, $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return parent::setByKey($server_key,$key,$value,$expiration,$udf_flags);
            $start = microtime(true);
            $name = 'setByKey';
            $arguments = array($server_key,$key,$value,$expiration,$udf_flags);
            $result = parent::setByKey($server_key,$key,$value,$expiration,$udf_flags);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setMulti( array $items, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return parent::setMulti($items,$expiration,$udf_flags);
            $start = microtime(true);
            $name = 'setMulti';
            $arguments = array($items,$expiration,$udf_flags);
            $result = parent::setMulti($items,$expiration,$udf_flags);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setMultiByKey( $server_key, array $items, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return parent::setMultiByKey($server_key,$items,$expiration,$udf_flags);
            $start = microtime(true);
            $name = 'setMultiByKey';
            $arguments = array($server_key,$items,$expiration,$udf_flags);
            $result = parent::setMultiByKey($server_key,$items,$expiration,$udf_flags);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function cas( $token, $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return parent::cas($token,$key,$value,$expiration,$udf_flags);
            $start = microtime(true);
            $name = 'cas';
            $arguments = array($token,$key,$value,$expiration,$udf_flags);
            $result = parent::cas($token,$key,$value,$expiration,$udf_flags);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function casByKey( $token, $server_key, $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return parent::casByKey($token,$server_key,$key,$value,$expiration,$udf_flags);
            $start = microtime(true);
            $name = 'casByKey';
            $arguments = array($token,$server_key,$key,$value,$expiration,$udf_flags);
            $result = parent::casByKey($token,$server_key,$key,$value,$expiration,$udf_flags);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function add( $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return parent::add($key,$value,$expiration,$udf_flags);
            $start = microtime(true);
            $name = 'add';
            $arguments = array($key,$value,$expiration,$udf_flags);
            $result = parent::add($key,$value,$expiration,$udf_flags);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addByKey( $server_key, $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return parent::addByKey($server_key,$key,$value,$expiration,$udf_flags);
            $start = microtime(true);
            $name = 'addByKey';
            $arguments = array($server_key,$key,$value,$expiration,$udf_flags);
            $result = parent::addByKey($server_key,$key,$value,$expiration,$udf_flags);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function append( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::append($key,$value,$expiration);
            $start = microtime(true);
            $name = 'append';
            $arguments = array($key,$value,$expiration);
            $result = parent::append($key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function appendByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::appendByKey($server_key,$key,$value,$expiration);
            $start = microtime(true);
            $name = 'appendByKey';
            $arguments = array($server_key,$key,$value,$expiration);
            $result = parent::appendByKey($server_key,$key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function prepend( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::prepend($key,$value,$expiration);
            $start = microtime(true);
            $name = 'prepend';
            $arguments = array($key,$value,$expiration);
            $result = parent::prepend($key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function prependByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return parent::prependByKey($server_key,$key,$value,$expiration);
            $start = microtime(true);
            $name = 'prependByKey';
            $arguments = array($server_key,$key,$value,$expiration);
            $result = parent::prependByKey($server_key,$key,$value,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function replace( $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return parent::replace($key,$value,$expiration,$udf_flags);
            $start = microtime(true);
            $name = 'replace';
            $arguments = array($key,$value,$expiration,$udf_flags);
            $result = parent::replace($key,$value,$expiration,$udf_flags);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function replaceByKey( $server_key, $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return parent::replaceByKey($server_key,$key,$value,$expiration,$udf_flags);
            $start = microtime(true);
            $name = 'replaceByKey';
            $arguments = array($server_key,$key,$value,$expiration,$udf_flags);
            $result = parent::replaceByKey($server_key,$key,$value,$expiration,$udf_flags);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function delete( $key, $time = 0 ) {
            if (!$this->logging) return parent::delete($key,$time);
            $start = microtime(true);
            $name = 'delete';
            $arguments = array($key,$time);
            $result = parent::delete($key,$time);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function deleteByKey( $server_key, $key, $time = 0 ) {
            if (!$this->logging) return parent::deleteByKey($server_key,$key,$time);
            $start = microtime(true);
            $name = 'deleteByKey';
            $arguments = array($server_key,$key,$time);
            $result = parent::deleteByKey($server_key,$key,$time);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function deleteMulti( $keys, $expiration = 0 ) {
            if (!$this->logging) return parent::deleteMulti($keys,$expiration);
            $start = microtime(true);
            $name = 'deleteMulti';
            $arguments = array($keys,$expiration);
            $result = parent::deleteMulti($keys,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function deleteMultiByKey( $server_key, $keys, $expiration = 0 ) {
            if (!$this->logging) return parent::deleteMultiByKey($server_key,$keys,$expiration);
            $start = microtime(true);
            $name = 'deleteMultiByKey';
            $arguments = array($server_key,$keys,$expiration);
            $result = parent::deleteMultiByKey($server_key,$keys,$expiration);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function increment( $key, $offset = 1, $initial_value = 0, $expiry = 0) {
            if (!$this->logging) return parent::increment($key,$offset,$initial_value,$expiry);
            $start = microtime(true);
            $name = 'increment';
            $arguments = array($key,$offset,$initial_value,$expiry);
            $result = parent::increment($key,$offset,$initial_value,$expiry);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function incrementByKey( $server_key, $key, $offset = 1, $initial_value = 0, $expiry = 0 ) {
            if (!$this->logging) return parent::incrementByKey($server_key,$key,$offset,$initial_value,$expiry);
            $start = microtime(true);
            $name = 'incrementByKey';
            $arguments = array($server_key,$key,$offset,$initial_value,$expiry);
            $result = parent::incrementByKey($server_key,$key,$offset,$initial_value,$expiry);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function decrement( $key, $offset = 1, $initial_value = 0, $expiry = 0) {
            if (!$this->logging) return parent::decrement($key,$offset,$initial_value,$expiry);
            $start = microtime(true);
            $name = 'decrement';
            $arguments = array($key,$offset,$initial_value,$expiry);
            $result = parent::decrement($key,$offset,$initial_value,$expiry);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function decrementByKey( $server_key, $key, $offset = 1, $initial_value = 0, $expiry = 0 ) {
            if (!$this->logging) return parent::decrementByKey($server_key,$key,$offset,$initial_value,$expiry);
            $start = microtime(true);
            $name = 'decrementByKey';
            $arguments = array($server_key,$key,$offset,$initial_value,$expiry);
            $result = parent::decrementByKey($server_key,$key,$offset,$initial_value,$expiry);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getOption( $option ) {
            if (!$this->logging) return parent::getOption($option);
            $start = microtime(true);
            $name = 'getOption';
            $arguments = array($option);
            $result = parent::getOption($option);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setOption( $option, $value ) {
            if (!$this->logging) return parent::setOption($option,$value);
            $start = microtime(true);
            $name = 'setOption';
            $arguments = array($option,$value);
            $result = parent::setOption($option,$value);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setOptions( $options ) {
            if (!$this->logging) return parent::setOptions($options);
            $start = microtime(true);
            $name = 'setOptions';
            $arguments = array($options);
            $result = parent::setOptions($options);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setBucket( $host_map, $forward_map, $replicas ) {
            if (!$this->logging) return parent::setBucket($host_map,$forward_map,$replicas);
            $start = microtime(true);
            $name = 'setBucket';
            $arguments = array($host_map,$forward_map,$replicas);
            $result = parent::setBucket($host_map,$forward_map,$replicas);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addServer( $host, $port,  $weight = 0 ) {
            if (!$this->logging) return parent::addServer($host,$port,$weight);
            $start = microtime(true);
            $name = 'addServer';
            $arguments = array($host,$port,$weight);
            $result = parent::addServer($host,$port,$weight);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addServers( array $servers ) {
            if (!$this->logging) return parent::addServers($servers);
            $start = microtime(true);
            $name = 'addServers';
            $arguments = array($servers);
            $result = parent::addServers($servers);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getServerList( ) {
            if (!$this->logging) return parent::getServerList();
            $start = microtime(true);
            $name = 'getServerList';
            $arguments = array();
            $result = parent::getServerList();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getServerByKey( $server_key ) {
            if (!$this->logging) return parent::getServerByKey($server_key);
            $start = microtime(true);
            $name = 'getServerByKey';
            $arguments = array($server_key);
            $result = parent::getServerByKey($server_key);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getLastErrorMessage( ) {
            if (!$this->logging) return parent::getLastErrorMessage();
            $start = microtime(true);
            $name = 'getLastErrorMessage';
            $arguments = array();
            $result = parent::getLastErrorMessage();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getLastErrorCode( ) {
            if (!$this->logging) return parent::getLastErrorCode();
            $start = microtime(true);
            $name = 'getLastErrorCode';
            $arguments = array();
            $result = parent::getLastErrorCode();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getLastErrorErrno( ) {
            if (!$this->logging) return parent::getLastErrorErrno();
            $start = microtime(true);
            $name = 'getLastErrorErrno';
            $arguments = array();
            $result = parent::getLastErrorErrno();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getLastDisconnectedServer( ) {
            if (!$this->logging) return parent::getLastDisconnectedServer();
            $start = microtime(true);
            $name = 'getLastDisconnectedServer';
            $arguments = array();
            $result = parent::getLastDisconnectedServer();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function flush( $delay = 0 ) {
            if (!$this->logging) return parent::flush($delay);
            $start = microtime(true);
            $name = 'flush';
            $arguments = array($delay);
            $result = parent::flush($delay);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getStats( ) {
            if (!$this->logging) return parent::getStats();
            $start = microtime(true);
            $name = 'getStats';
            $arguments = array();
            $result = parent::getStats();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getVersion( ) {
            if (!$this->logging) return parent::getVersion();
            $start = microtime(true);
            $name = 'getVersion';
            $arguments = array();
            $result = parent::getVersion();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getResultCode( ) {
            if (!$this->logging) return parent::getResultCode();
            $start = microtime(true);
            $name = 'getResultCode';
            $arguments = array();
            $result = parent::getResultCode();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getResultMessage( ) {
            if (!$this->logging) return parent::getResultMessage();
            $start = microtime(true);
            $name = 'getResultMessage';
            $arguments = array();
            $result = parent::getResultMessage();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function isPersistent( ) {
            if (!$this->logging) return parent::isPersistent();
            $start = microtime(true);
            $name = 'isPersistent';
            $arguments = array();
            $result = parent::isPersistent();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function isPristine( ) {
            if (!$this->logging) return parent::isPristine();
            $start = microtime(true);
            $name = 'isPristine';
            $arguments = array();
            $result = parent::isPristine();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setSaslAuthData( $username, $password ) {
            if (!$this->logging) return parent::setSaslAuthData($username,$password);
            $start = microtime(true);
            $name = 'setSaslAuthData';
            $arguments = array($username,$password);
            $result = parent::setSaslAuthData($username,$password);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
    }
} else {
    throw new \Exception('LswMemcacheBundle does not support version '.$extension->getVersion().' of the memcached extension.');
}
