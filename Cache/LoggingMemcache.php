<?php
namespace Lsw\MemcacheBundle\Cache;

$extension = new \ReflectionExtension('memcached');
if ($extension->getVersion()=='1.0.2') {
    class LoggingMemcache extends \Memcached implements MemcacheInterface, LoggingMemcacheInterface {
        public function __construct($logging, $persistentId = '') {
            $this->calls = array();
            $this->logging = $logging;
            if ($persistentId) {
                $this->initialize = count($this->getServerList())==0;
            } else {
                $this->initialize = true;
            }
            $arguments = func_get_args();
            array_shift($arguments);
            forward_static_call_array("parent::__construct", $arguments);
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
            if (!$this->logging) return forward_static_call_array('parent::get', func_get_args());
            $start = microtime(true);
            $name = 'get';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getByKey( $server_key, $key, $cache_cb = null, &$cas_token = null ) {
            if (!$this->logging) return forward_static_call_array('parent::getByKey', func_get_args());
            $start = microtime(true);
            $name = 'getByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getMulti( array $keys, &$cas_tokens = null, $flags = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::getMulti', func_get_args());
            $start = microtime(true);
            $name = 'getMulti';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getMultiByKey( $server_key, array $keys, &$cas_tokens = null, $flags = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::getMultiByKey', func_get_args());
            $start = microtime(true);
            $name = 'getMultiByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getDelayed( array $keys, $with_cas = null, $value_cb = null ) {
            if (!$this->logging) return forward_static_call_array('parent::getDelayed', func_get_args());
            $start = microtime(true);
            $name = 'getDelayed';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getDelayedByKey( $server_key, array $keys, $with_cas = null, $value_cb = null ) {
            if (!$this->logging) return forward_static_call_array('parent::getDelayedByKey', func_get_args());
            $start = microtime(true);
            $name = 'getDelayedByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function fetch( ) {
            if (!$this->logging) return forward_static_call_array('parent::fetch', func_get_args());
            $start = microtime(true);
            $name = 'fetch';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function fetchAll( ) {
            if (!$this->logging) return forward_static_call_array('parent::fetchAll', func_get_args());
            $start = microtime(true);
            $name = 'fetchAll';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function set( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::set', func_get_args());
            $start = microtime(true);
            $name = 'set';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::setByKey', func_get_args());
            $start = microtime(true);
            $name = 'setByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setMulti( array $items, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::setMulti', func_get_args());
            $start = microtime(true);
            $name = 'setMulti';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setMultiByKey( $server_key, array $items, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::setMultiByKey', func_get_args());
            $start = microtime(true);
            $name = 'setMultiByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function cas( $token, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::cas', func_get_args());
            $start = microtime(true);
            $name = 'cas';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function casByKey( $token, $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::casByKey', func_get_args());
            $start = microtime(true);
            $name = 'casByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function add( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::add', func_get_args());
            $start = microtime(true);
            $name = 'add';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::addByKey', func_get_args());
            $start = microtime(true);
            $name = 'addByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function append( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::append', func_get_args());
            $start = microtime(true);
            $name = 'append';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function appendByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::appendByKey', func_get_args());
            $start = microtime(true);
            $name = 'appendByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function prepend( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::prepend', func_get_args());
            $start = microtime(true);
            $name = 'prepend';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function prependByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::prependByKey', func_get_args());
            $start = microtime(true);
            $name = 'prependByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function replace( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::replace', func_get_args());
            $start = microtime(true);
            $name = 'replace';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function replaceByKey( $serve_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::replaceByKey', func_get_args());
            $start = microtime(true);
            $name = 'replaceByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function delete( $key, $time = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::delete', func_get_args());
            $start = microtime(true);
            $name = 'delete';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function deleteByKey( $server_key, $key, $time = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::deleteByKey', func_get_args());
            $start = microtime(true);
            $name = 'deleteByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function increment( $key, $offset = 1) {
            if (!$this->logging) return forward_static_call_array('parent::increment', func_get_args());
            $start = microtime(true);
            $name = 'increment';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function decrement( $key, $offset = 1) {
            if (!$this->logging) return forward_static_call_array('parent::decrement', func_get_args());
            $start = microtime(true);
            $name = 'decrement';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getOption( $option ) {
            if (!$this->logging) return forward_static_call_array('parent::getOption', func_get_args());
            $start = microtime(true);
            $name = 'getOption';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setOption( $option, $value ) {
            if (!$this->logging) return forward_static_call_array('parent::setOption', func_get_args());
            $start = microtime(true);
            $name = 'setOption';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addServer( $host, $port,  $weight = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::addServer', func_get_args());
            $start = microtime(true);
            $name = 'addServer';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addServers( array $servers ) {
            if (!$this->logging) return forward_static_call_array('parent::addServers', func_get_args());
            $start = microtime(true);
            $name = 'addServers';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getServerList( ) {
            if (!$this->logging) return forward_static_call_array('parent::getServerList', func_get_args());
            $start = microtime(true);
            $name = 'getServerList';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getServerByKey( $server_key ) {
            if (!$this->logging) return forward_static_call_array('parent::getServerByKey', func_get_args());
            $start = microtime(true);
            $name = 'getServerByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function flush( $delay = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::flush', func_get_args());
            $start = microtime(true);
            $name = 'flush';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getStats( ) {
            if (!$this->logging) return forward_static_call_array('parent::getStats', func_get_args());
            $start = microtime(true);
            $name = 'getStats';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getResultCode( ) {
            if (!$this->logging) return forward_static_call_array('parent::getResultCode', func_get_args());
            $start = microtime(true);
            $name = 'getResultCode';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getResultMessage( ) {
            if (!$this->logging) return forward_static_call_array('parent::getResultMessage', func_get_args());
            $start = microtime(true);
            $name = 'getResultMessage';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
    }
} else if ($extension->getVersion()=='2.0.1') {
    class LoggingMemcache extends \Memcached implements MemcacheInterface, LoggingMemcacheInterface {
        public function __construct($logging, $persistentId = '') {
            $this->calls = array();
            $this->logging = $logging;
            if ($persistentId) {
                $this->initialize = count($this->getServerList())==0;
            } else {
                $this->initialize = true;
            }
            $arguments = func_get_args();
            array_shift($arguments);
            forward_static_call_array("parent::__construct", $arguments);
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
            if (!$this->logging) return forward_static_call_array('parent::get', func_get_args());
            $start = microtime(true);
            $name = 'get';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getByKey( $server_key, $key, $cache_cb = null, &$cas_token = null ) {
            if (!$this->logging) return forward_static_call_array('parent::getByKey', func_get_args());
            $start = microtime(true);
            $name = 'getByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getMulti( array $keys, &$cas_tokens = null, $flags = null ) {
            if (!$this->logging) return forward_static_call_array('parent::getMulti', func_get_args());
            $start = microtime(true);
            $name = 'getMulti';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getMultiByKey( $server_key, array $keys, &$cas_tokens = null, $flags = null ) {
            if (!$this->logging) return forward_static_call_array('parent::getMultiByKey', func_get_args());
            $start = microtime(true);
            $name = 'getMultiByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getDelayed( array $keys, $with_cas = null, $value_cb = null ) {
            if (!$this->logging) return forward_static_call_array('parent::getDelayed', func_get_args());
            $start = microtime(true);
            $name = 'getDelayed';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getDelayedByKey( $server_key, array $keys, $with_cas = null, $value_cb = null ) {
            if (!$this->logging) return forward_static_call_array('parent::getDelayedByKey', func_get_args());
            $start = microtime(true);
            $name = 'getDelayedByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function fetch( ) {
            if (!$this->logging) return forward_static_call_array('parent::fetch', func_get_args());
            $start = microtime(true);
            $name = 'fetch';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function fetchAll( ) {
            if (!$this->logging) return forward_static_call_array('parent::fetchAll', func_get_args());
            $start = microtime(true);
            $name = 'fetchAll';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function set( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::set', func_get_args());
            $start = microtime(true);
            $name = 'set';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function touch( $key, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::touch', func_get_args());
            $start = microtime(true);
            $name = 'touch';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function touchbyKey( $server_key, $key, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::touchbyKey', func_get_args());
            $start = microtime(true);
            $name = 'touchbyKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::setByKey', func_get_args());
            $start = microtime(true);
            $name = 'setByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setMulti( array $items, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::setMulti', func_get_args());
            $start = microtime(true);
            $name = 'setMulti';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setMultiByKey( $server_key, array $items, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::setMultiByKey', func_get_args());
            $start = microtime(true);
            $name = 'setMultiByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function cas( $token, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::cas', func_get_args());
            $start = microtime(true);
            $name = 'cas';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function casByKey( $token, $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::casByKey', func_get_args());
            $start = microtime(true);
            $name = 'casByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function add( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::add', func_get_args());
            $start = microtime(true);
            $name = 'add';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::addByKey', func_get_args());
            $start = microtime(true);
            $name = 'addByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function append( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::append', func_get_args());
            $start = microtime(true);
            $name = 'append';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function appendByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::appendByKey', func_get_args());
            $start = microtime(true);
            $name = 'appendByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function prepend( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::prepend', func_get_args());
            $start = microtime(true);
            $name = 'prepend';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function prependByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::prependByKey', func_get_args());
            $start = microtime(true);
            $name = 'prependByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function replace( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::replace', func_get_args());
            $start = microtime(true);
            $name = 'replace';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function replaceByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::replaceByKey', func_get_args());
            $start = microtime(true);
            $name = 'replaceByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function delete( $key, $time = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::delete', func_get_args());
            $start = microtime(true);
            $name = 'delete';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function deleteByKey( $server_key, $key, $time = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::deleteByKey', func_get_args());
            $start = microtime(true);
            $name = 'deleteByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function deleteMulti( $keys, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::deleteMulti', func_get_args());
            $start = microtime(true);
            $name = 'deleteMulti';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function deleteMultiByKey( $server_key, $keys, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::deleteMultiByKey', func_get_args());
            $start = microtime(true);
            $name = 'deleteMultiByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function increment( $key, $offset = 1, $initial_value = 0, $expiry = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::increment', func_get_args());
            $start = microtime(true);
            $name = 'increment';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function incrementByKey( $server_key, $key, $offset = 1, $initial_value = 0, $expiry = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::incrementByKey', func_get_args());
            $start = microtime(true);
            $name = 'incrementByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function decrement( $key, $offset = 1, $initial_value = 0, $expiry = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::decrement', func_get_args());
            $start = microtime(true);
            $name = 'decrement';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function decrementByKey( $server_key, $key, $offset = 1, $initial_value = 0, $expiry = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::decrementByKey', func_get_args());
            $start = microtime(true);
            $name = 'decrementByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getOption( $option ) {
            if (!$this->logging) return forward_static_call_array('parent::getOption', func_get_args());
            $start = microtime(true);
            $name = 'getOption';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setOption( $option, $value ) {
            if (!$this->logging) return forward_static_call_array('parent::setOption', func_get_args());
            $start = microtime(true);
            $name = 'setOption';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setOptions( $options ) {
            if (!$this->logging) return forward_static_call_array('parent::setOptions', func_get_args());
            $start = microtime(true);
            $name = 'setOptions';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addServer( $host, $port,  $weight = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::addServer', func_get_args());
            $start = microtime(true);
            $name = 'addServer';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addServers( array $servers ) {
            if (!$this->logging) return forward_static_call_array('parent::addServers', func_get_args());
            $start = microtime(true);
            $name = 'addServers';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getServerList( ) {
            if (!$this->logging) return forward_static_call_array('parent::getServerList', func_get_args());
            $start = microtime(true);
            $name = 'getServerList';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getServerByKey( $server_key ) {
            if (!$this->logging) return forward_static_call_array('parent::getServerByKey', func_get_args());
            $start = microtime(true);
            $name = 'getServerByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function flush( $delay = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::flush', func_get_args());
            $start = microtime(true);
            $name = 'flush';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getStats( ) {
            if (!$this->logging) return forward_static_call_array('parent::getStats', func_get_args());
            $start = microtime(true);
            $name = 'getStats';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getVersion( ) {
            if (!$this->logging) return forward_static_call_array('parent::getVersion', func_get_args());
            $start = microtime(true);
            $name = 'getVersion';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getResultCode( ) {
            if (!$this->logging) return forward_static_call_array('parent::getResultCode', func_get_args());
            $start = microtime(true);
            $name = 'getResultCode';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getResultMessage( ) {
            if (!$this->logging) return forward_static_call_array('parent::getResultMessage', func_get_args());
            $start = microtime(true);
            $name = 'getResultMessage';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function isPersistent( ) {
            if (!$this->logging) return forward_static_call_array('parent::isPersistent', func_get_args());
            $start = microtime(true);
            $name = 'isPersistent';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function isPristine( ) {
            if (!$this->logging) return forward_static_call_array('parent::isPristine', func_get_args());
            $start = microtime(true);
            $name = 'isPristine';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
    }
} else if ($extension->getVersion()=='2.1.0') {
    class LoggingMemcache extends \Memcached implements MemcacheInterface, LoggingMemcacheInterface {
        public function __construct($logging, $persistentId = '') {
            $this->calls = array();
            $this->logging = $logging;
            if ($persistentId) {
                $this->initialize = count($this->getServerList())==0;
            } else {
                $this->initialize = true;
            }
            $arguments = func_get_args();
            array_shift($arguments);
            forward_static_call_array("parent::__construct", $arguments);
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
            if (!$this->logging) return forward_static_call_array('parent::get', func_get_args());
            $start = microtime(true);
            $name = 'get';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getByKey( $server_key, $key, $cache_cb = null, &$cas_token = null ) {
            if (!$this->logging) return forward_static_call_array('parent::getByKey', func_get_args());
            $start = microtime(true);
            $name = 'getByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getMulti( array $keys, &$cas_tokens = null, $flags = null ) {
            if (!$this->logging) return forward_static_call_array('parent::getMulti', func_get_args());
            $start = microtime(true);
            $name = 'getMulti';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getMultiByKey( $server_key, array $keys, &$cas_tokens = null, $flags = null ) {
            if (!$this->logging) return forward_static_call_array('parent::getMultiByKey', func_get_args());
            $start = microtime(true);
            $name = 'getMultiByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getDelayed( array $keys, $with_cas = null, $value_cb = null ) {
            if (!$this->logging) return forward_static_call_array('parent::getDelayed', func_get_args());
            $start = microtime(true);
            $name = 'getDelayed';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getDelayedByKey( $server_key, array $keys, $with_cas = null, $value_cb = null ) {
            if (!$this->logging) return forward_static_call_array('parent::getDelayedByKey', func_get_args());
            $start = microtime(true);
            $name = 'getDelayedByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function fetch( ) {
            if (!$this->logging) return forward_static_call_array('parent::fetch', func_get_args());
            $start = microtime(true);
            $name = 'fetch';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function fetchAll( ) {
            if (!$this->logging) return forward_static_call_array('parent::fetchAll', func_get_args());
            $start = microtime(true);
            $name = 'fetchAll';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function set( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::set', func_get_args());
            $start = microtime(true);
            $name = 'set';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function touch( $key, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::touch', func_get_args());
            $start = microtime(true);
            $name = 'touch';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function touchbyKey( $server_key, $key, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::touchbyKey', func_get_args());
            $start = microtime(true);
            $name = 'touchbyKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::setByKey', func_get_args());
            $start = microtime(true);
            $name = 'setByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setMulti( array $items, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::setMulti', func_get_args());
            $start = microtime(true);
            $name = 'setMulti';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setMultiByKey( $server_key, array $items, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::setMultiByKey', func_get_args());
            $start = microtime(true);
            $name = 'setMultiByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function cas( $token, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::cas', func_get_args());
            $start = microtime(true);
            $name = 'cas';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function casByKey( $token, $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::casByKey', func_get_args());
            $start = microtime(true);
            $name = 'casByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function add( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::add', func_get_args());
            $start = microtime(true);
            $name = 'add';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::addByKey', func_get_args());
            $start = microtime(true);
            $name = 'addByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function append( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::append', func_get_args());
            $start = microtime(true);
            $name = 'append';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function appendByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::appendByKey', func_get_args());
            $start = microtime(true);
            $name = 'appendByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function prepend( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::prepend', func_get_args());
            $start = microtime(true);
            $name = 'prepend';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function prependByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::prependByKey', func_get_args());
            $start = microtime(true);
            $name = 'prependByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function replace( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::replace', func_get_args());
            $start = microtime(true);
            $name = 'replace';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function replaceByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::replaceByKey', func_get_args());
            $start = microtime(true);
            $name = 'replaceByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function delete( $key, $time = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::delete', func_get_args());
            $start = microtime(true);
            $name = 'delete';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function deleteByKey( $server_key, $key, $time = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::deleteByKey', func_get_args());
            $start = microtime(true);
            $name = 'deleteByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function deleteMulti( $keys, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::deleteMulti', func_get_args());
            $start = microtime(true);
            $name = 'deleteMulti';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function deleteMultiByKey( $server_key, $keys, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::deleteMultiByKey', func_get_args());
            $start = microtime(true);
            $name = 'deleteMultiByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function increment( $key, $offset = 1, $initial_value = 0, $expiry = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::increment', func_get_args());
            $start = microtime(true);
            $name = 'increment';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function incrementByKey( $server_key, $key, $offset = 1, $initial_value = 0, $expiry = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::incrementByKey', func_get_args());
            $start = microtime(true);
            $name = 'incrementByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function decrement( $key, $offset = 1, $initial_value = 0, $expiry = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::decrement', func_get_args());
            $start = microtime(true);
            $name = 'decrement';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function decrementByKey( $server_key, $key, $offset = 1, $initial_value = 0, $expiry = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::decrementByKey', func_get_args());
            $start = microtime(true);
            $name = 'decrementByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getOption( $option ) {
            if (!$this->logging) return forward_static_call_array('parent::getOption', func_get_args());
            $start = microtime(true);
            $name = 'getOption';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setOption( $option, $value ) {
            if (!$this->logging) return forward_static_call_array('parent::setOption', func_get_args());
            $start = microtime(true);
            $name = 'setOption';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setOptions( $options ) {
            if (!$this->logging) return forward_static_call_array('parent::setOptions', func_get_args());
            $start = microtime(true);
            $name = 'setOptions';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addServer( $host, $port,  $weight = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::addServer', func_get_args());
            $start = microtime(true);
            $name = 'addServer';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addServers( array $servers ) {
            if (!$this->logging) return forward_static_call_array('parent::addServers', func_get_args());
            $start = microtime(true);
            $name = 'addServers';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getServerList( ) {
            if (!$this->logging) return forward_static_call_array('parent::getServerList', func_get_args());
            $start = microtime(true);
            $name = 'getServerList';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getServerByKey( $server_key ) {
            if (!$this->logging) return forward_static_call_array('parent::getServerByKey', func_get_args());
            $start = microtime(true);
            $name = 'getServerByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function flush( $delay = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::flush', func_get_args());
            $start = microtime(true);
            $name = 'flush';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getStats( ) {
            if (!$this->logging) return forward_static_call_array('parent::getStats', func_get_args());
            $start = microtime(true);
            $name = 'getStats';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getVersion( ) {
            if (!$this->logging) return forward_static_call_array('parent::getVersion', func_get_args());
            $start = microtime(true);
            $name = 'getVersion';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getResultCode( ) {
            if (!$this->logging) return forward_static_call_array('parent::getResultCode', func_get_args());
            $start = microtime(true);
            $name = 'getResultCode';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getResultMessage( ) {
            if (!$this->logging) return forward_static_call_array('parent::getResultMessage', func_get_args());
            $start = microtime(true);
            $name = 'getResultMessage';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function isPersistent( ) {
            if (!$this->logging) return forward_static_call_array('parent::isPersistent', func_get_args());
            $start = microtime(true);
            $name = 'isPersistent';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function isPristine( ) {
            if (!$this->logging) return forward_static_call_array('parent::isPristine', func_get_args());
            $start = microtime(true);
            $name = 'isPristine';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
    }
} else if ($extension->getVersion()=='2.2.0') {
    class LoggingMemcache extends \Memcached implements MemcacheInterface, LoggingMemcacheInterface {
        public function __construct($logging, $persistentId = '') {
            $this->calls = array();
            $this->logging = $logging;
            if ($persistentId) {
                $this->initialize = count($this->getServerList())==0;
            } else {
                $this->initialize = true;
            }
            $arguments = func_get_args();
            array_shift($arguments);
            forward_static_call_array("parent::__construct", $arguments);
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
            if (!$this->logging) return forward_static_call_array('parent::get', func_get_args());
            $start = microtime(true);
            $name = 'get';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getByKey( $server_key, $key, $cache_cb = null, &$cas_token = null, &$udf_flags = null ) {
            if (!$this->logging) return forward_static_call_array('parent::getByKey', func_get_args());
            $start = microtime(true);
            $name = 'getByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getMulti( array $keys, &$cas_tokens = null, $flags = null, &$udf_flags = null ) {
            if (!$this->logging) return forward_static_call_array('parent::getMulti', func_get_args());
            $start = microtime(true);
            $name = 'getMulti';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getMultiByKey( $server_key, array $keys, &$cas_tokens = null, $flags = null, &$udf_flags = null ) {
            if (!$this->logging) return forward_static_call_array('parent::getMultiByKey', func_get_args());
            $start = microtime(true);
            $name = 'getMultiByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getDelayed( array $keys, $with_cas = null, $value_cb = null ) {
            if (!$this->logging) return forward_static_call_array('parent::getDelayed', func_get_args());
            $start = microtime(true);
            $name = 'getDelayed';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getDelayedByKey( $server_key, array $keys, $with_cas = null, $value_cb = null ) {
            if (!$this->logging) return forward_static_call_array('parent::getDelayedByKey', func_get_args());
            $start = microtime(true);
            $name = 'getDelayedByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function fetch( ) {
            if (!$this->logging) return forward_static_call_array('parent::fetch', func_get_args());
            $start = microtime(true);
            $name = 'fetch';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function fetchAll( ) {
            if (!$this->logging) return forward_static_call_array('parent::fetchAll', func_get_args());
            $start = microtime(true);
            $name = 'fetchAll';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function set( $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::set', func_get_args());
            $start = microtime(true);
            $name = 'set';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function touch( $key, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::touch', func_get_args());
            $start = microtime(true);
            $name = 'touch';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function touchbyKey( $server_key, $key, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::touchbyKey', func_get_args());
            $start = microtime(true);
            $name = 'touchbyKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setByKey( $server_key, $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::setByKey', func_get_args());
            $start = microtime(true);
            $name = 'setByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setMulti( array $items, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::setMulti', func_get_args());
            $start = microtime(true);
            $name = 'setMulti';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setMultiByKey( $server_key, array $items, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::setMultiByKey', func_get_args());
            $start = microtime(true);
            $name = 'setMultiByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function cas( $token, $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::cas', func_get_args());
            $start = microtime(true);
            $name = 'cas';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function casByKey( $token, $server_key, $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::casByKey', func_get_args());
            $start = microtime(true);
            $name = 'casByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function add( $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::add', func_get_args());
            $start = microtime(true);
            $name = 'add';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addByKey( $server_key, $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::addByKey', func_get_args());
            $start = microtime(true);
            $name = 'addByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function append( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::append', func_get_args());
            $start = microtime(true);
            $name = 'append';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function appendByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::appendByKey', func_get_args());
            $start = microtime(true);
            $name = 'appendByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function prepend( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::prepend', func_get_args());
            $start = microtime(true);
            $name = 'prepend';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function prependByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::prependByKey', func_get_args());
            $start = microtime(true);
            $name = 'prependByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function replace( $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::replace', func_get_args());
            $start = microtime(true);
            $name = 'replace';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function replaceByKey( $server_key, $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::replaceByKey', func_get_args());
            $start = microtime(true);
            $name = 'replaceByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function delete( $key, $time = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::delete', func_get_args());
            $start = microtime(true);
            $name = 'delete';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function deleteByKey( $server_key, $key, $time = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::deleteByKey', func_get_args());
            $start = microtime(true);
            $name = 'deleteByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function deleteMulti( $keys, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::deleteMulti', func_get_args());
            $start = microtime(true);
            $name = 'deleteMulti';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function deleteMultiByKey( $server_key, $keys, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::deleteMultiByKey', func_get_args());
            $start = microtime(true);
            $name = 'deleteMultiByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function increment( $key, $offset = 1, $initial_value = 0, $expiry = 0) {
            if (!$this->logging) return forward_static_call_array('parent::increment', func_get_args());
            $start = microtime(true);
            $name = 'increment';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function incrementByKey( $server_key, $key, $offset = 1, $initial_value = 0, $expiry = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::incrementByKey', func_get_args());
            $start = microtime(true);
            $name = 'incrementByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function decrement( $key, $offset = 1, $initial_value = 0, $expiry = 0) {
            if (!$this->logging) return forward_static_call_array('parent::decrement', func_get_args());
            $start = microtime(true);
            $name = 'decrement';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function decrementByKey( $server_key, $key, $offset = 1, $initial_value = 0, $expiry = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::decrementByKey', func_get_args());
            $start = microtime(true);
            $name = 'decrementByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getOption( $option ) {
            if (!$this->logging) return forward_static_call_array('parent::getOption', func_get_args());
            $start = microtime(true);
            $name = 'getOption';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setOption( $option, $value ) {
            if (!$this->logging) return forward_static_call_array('parent::setOption', func_get_args());
            $start = microtime(true);
            $name = 'setOption';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setOptions( $options ) {
            if (!$this->logging) return forward_static_call_array('parent::setOptions', func_get_args());
            $start = microtime(true);
            $name = 'setOptions';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setBucket( $host_map, $forward_map, $replicas ) {
            if (!$this->logging) return forward_static_call_array('parent::setBucket', func_get_args());
            $start = microtime(true);
            $name = 'setBucket';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addServer( $host, $port,  $weight = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::addServer', func_get_args());
            $start = microtime(true);
            $name = 'addServer';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addServers( array $servers ) {
            if (!$this->logging) return forward_static_call_array('parent::addServers', func_get_args());
            $start = microtime(true);
            $name = 'addServers';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getServerList( ) {
            if (!$this->logging) return forward_static_call_array('parent::getServerList', func_get_args());
            $start = microtime(true);
            $name = 'getServerList';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getServerByKey( $server_key ) {
            if (!$this->logging) return forward_static_call_array('parent::getServerByKey', func_get_args());
            $start = microtime(true);
            $name = 'getServerByKey';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getLastErrorMessage( ) {
            if (!$this->logging) return forward_static_call_array('parent::getLastErrorMessage', func_get_args());
            $start = microtime(true);
            $name = 'getLastErrorMessage';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getLastErrorCode( ) {
            if (!$this->logging) return forward_static_call_array('parent::getLastErrorCode', func_get_args());
            $start = microtime(true);
            $name = 'getLastErrorCode';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getLastErrorErrno( ) {
            if (!$this->logging) return forward_static_call_array('parent::getLastErrorErrno', func_get_args());
            $start = microtime(true);
            $name = 'getLastErrorErrno';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getLastDisconnectedServer( ) {
            if (!$this->logging) return forward_static_call_array('parent::getLastDisconnectedServer', func_get_args());
            $start = microtime(true);
            $name = 'getLastDisconnectedServer';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function flush( $delay = 0 ) {
            if (!$this->logging) return forward_static_call_array('parent::flush', func_get_args());
            $start = microtime(true);
            $name = 'flush';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getStats( ) {
            if (!$this->logging) return forward_static_call_array('parent::getStats', func_get_args());
            $start = microtime(true);
            $name = 'getStats';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getVersion( ) {
            if (!$this->logging) return forward_static_call_array('parent::getVersion', func_get_args());
            $start = microtime(true);
            $name = 'getVersion';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getResultCode( ) {
            if (!$this->logging) return forward_static_call_array('parent::getResultCode', func_get_args());
            $start = microtime(true);
            $name = 'getResultCode';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getResultMessage( ) {
            if (!$this->logging) return forward_static_call_array('parent::getResultMessage', func_get_args());
            $start = microtime(true);
            $name = 'getResultMessage';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function isPersistent( ) {
            if (!$this->logging) return forward_static_call_array('parent::isPersistent', func_get_args());
            $start = microtime(true);
            $name = 'isPersistent';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function isPristine( ) {
            if (!$this->logging) return forward_static_call_array('parent::isPristine', func_get_args());
            $start = microtime(true);
            $name = 'isPristine';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setSaslAuthData( $username, $password ) {
            if (!$this->logging) return forward_static_call_array('parent::setSaslAuthData', func_get_args());
            $start = microtime(true);
            $name = 'setSaslAuthData';
            $arguments = func_get_args();
            $result = forward_static_call_array("parent::$name", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
    }
} else {
    throw new \Exception('LswMemcacheBundle does not support version '.$extension->getVersion().' of the memcached extension.');
}
