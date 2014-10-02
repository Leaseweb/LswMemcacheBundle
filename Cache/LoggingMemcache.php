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
            forward_static_call("parent::__construct", $persistent_id);
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
            if (!$this->logging) return forward_static_call("parent::get", func_get_args());
            $start = microtime(true);
            $name = 'get';
            $arguments = array($key,$cache_cb,$cas_token);
            $result = forward_static_call_array("parent::get", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getByKey( $server_key, $key, $cache_cb = null, &$cas_token = null ) {
            if (!$this->logging) return forward_static_call("parent::getByKey", func_get_args());
            $start = microtime(true);
            $name = 'getByKey';
            $arguments = array($server_key,$key,$cache_cb,$cas_token);
            $result = forward_static_call_array("parent::getByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getMulti( array $keys, &$cas_tokens = null, $flags = 0 ) {
            if (!$this->logging) return forward_static_call("parent::getMulti", func_get_args());
            $start = microtime(true);
            $name = 'getMulti';
            $arguments = array($keys,$cas_tokens,$flags);
            $result = forward_static_call_array("parent::getMulti", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getMultiByKey( $server_key, array $keys, &$cas_tokens = null, $flags = 0 ) {
            if (!$this->logging) return forward_static_call("parent::getMultiByKey", func_get_args());
            $start = microtime(true);
            $name = 'getMultiByKey';
            $arguments = array($server_key,$keys,$cas_tokens,$flags);
            $result = forward_static_call_array("parent::getMultiByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getDelayed( array $keys, $with_cas = null, $value_cb = null ) {
            if (!$this->logging) return forward_static_call("parent::getDelayed", func_get_args());
            $start = microtime(true);
            $name = 'getDelayed';
            $arguments = array($keys,$with_cas,$value_cb);
            $result = forward_static_call_array("parent::getDelayed", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getDelayedByKey( $server_key, array $keys, $with_cas = null, $value_cb = null ) {
            if (!$this->logging) return forward_static_call("parent::getDelayedByKey", func_get_args());
            $start = microtime(true);
            $name = 'getDelayedByKey';
            $arguments = array($server_key,$keys,$with_cas,$value_cb);
            $result = forward_static_call_array("parent::getDelayedByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function fetch( ) {
            if (!$this->logging) return forward_static_call("parent::fetch", func_get_args());
            $start = microtime(true);
            $name = 'fetch';
            $arguments = array();
            $result = forward_static_call_array("parent::fetch", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function fetchAll( ) {
            if (!$this->logging) return forward_static_call("parent::fetchAll", func_get_args());
            $start = microtime(true);
            $name = 'fetchAll';
            $arguments = array();
            $result = forward_static_call_array("parent::fetchAll", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function set( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::set", func_get_args());
            $start = microtime(true);
            $name = 'set';
            $arguments = array($key,$value,$expiration);
            $result = forward_static_call_array("parent::set", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::setByKey", func_get_args());
            $start = microtime(true);
            $name = 'setByKey';
            $arguments = array($server_key,$key,$value,$expiration);
            $result = forward_static_call_array("parent::setByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setMulti( array $items, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::setMulti", func_get_args());
            $start = microtime(true);
            $name = 'setMulti';
            $arguments = array($items,$expiration);
            $result = forward_static_call_array("parent::setMulti", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setMultiByKey( $server_key, array $items, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::setMultiByKey", func_get_args());
            $start = microtime(true);
            $name = 'setMultiByKey';
            $arguments = array($server_key,$items,$expiration);
            $result = forward_static_call_array("parent::setMultiByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function cas( $token, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::cas", func_get_args());
            $start = microtime(true);
            $name = 'cas';
            $arguments = array($token,$key,$value,$expiration);
            $result = forward_static_call_array("parent::cas", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function casByKey( $token, $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::casByKey", func_get_args());
            $start = microtime(true);
            $name = 'casByKey';
            $arguments = array($token,$server_key,$key,$value,$expiration);
            $result = forward_static_call_array("parent::casByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function add( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::add", func_get_args());
            $start = microtime(true);
            $name = 'add';
            $arguments = array($key,$value,$expiration);
            $result = forward_static_call_array("parent::add", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::addByKey", func_get_args());
            $start = microtime(true);
            $name = 'addByKey';
            $arguments = array($server_key,$key,$value,$expiration);
            $result = forward_static_call_array("parent::addByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function append( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::append", func_get_args());
            $start = microtime(true);
            $name = 'append';
            $arguments = array($key,$value,$expiration);
            $result = forward_static_call_array("parent::append", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function appendByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::appendByKey", func_get_args());
            $start = microtime(true);
            $name = 'appendByKey';
            $arguments = array($server_key,$key,$value,$expiration);
            $result = forward_static_call_array("parent::appendByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function prepend( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::prepend", func_get_args());
            $start = microtime(true);
            $name = 'prepend';
            $arguments = array($key,$value,$expiration);
            $result = forward_static_call_array("parent::prepend", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function prependByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::prependByKey", func_get_args());
            $start = microtime(true);
            $name = 'prependByKey';
            $arguments = array($server_key,$key,$value,$expiration);
            $result = forward_static_call_array("parent::prependByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function replace( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::replace", func_get_args());
            $start = microtime(true);
            $name = 'replace';
            $arguments = array($key,$value,$expiration);
            $result = forward_static_call_array("parent::replace", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function replaceByKey( $serve_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::replaceByKey", func_get_args());
            $start = microtime(true);
            $name = 'replaceByKey';
            $arguments = array($serve_key,$key,$value,$expiration);
            $result = forward_static_call_array("parent::replaceByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function delete( $key, $time = 0 ) {
            if (!$this->logging) return forward_static_call("parent::delete", func_get_args());
            $start = microtime(true);
            $name = 'delete';
            $arguments = array($key,$time);
            $result = forward_static_call_array("parent::delete", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function deleteByKey( $server_key, $key, $time = 0 ) {
            if (!$this->logging) return forward_static_call("parent::deleteByKey", func_get_args());
            $start = microtime(true);
            $name = 'deleteByKey';
            $arguments = array($server_key,$key,$time);
            $result = forward_static_call_array("parent::deleteByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function increment( $key, $offset = 1) {
            if (!$this->logging) return forward_static_call("parent::increment", func_get_args());
            $start = microtime(true);
            $name = 'increment';
            $arguments = array($key,$offset);
            $result = forward_static_call_array("parent::increment", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function decrement( $key, $offset = 1) {
            if (!$this->logging) return forward_static_call("parent::decrement", func_get_args());
            $start = microtime(true);
            $name = 'decrement';
            $arguments = array($key,$offset);
            $result = forward_static_call_array("parent::decrement", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getOption( $option ) {
            if (!$this->logging) return forward_static_call("parent::getOption", func_get_args());
            $start = microtime(true);
            $name = 'getOption';
            $arguments = array($option);
            $result = forward_static_call_array("parent::getOption", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setOption( $option, $value ) {
            if (!$this->logging) return forward_static_call("parent::setOption", func_get_args());
            $start = microtime(true);
            $name = 'setOption';
            $arguments = array($option,$value);
            $result = forward_static_call_array("parent::setOption", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addServer( $host, $port,  $weight = 0 ) {
            if (!$this->logging) return forward_static_call("parent::addServer", func_get_args());
            $start = microtime(true);
            $name = 'addServer';
            $arguments = array($host,$port,$weight);
            $result = forward_static_call_array("parent::addServer", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addServers( array $servers ) {
            if (!$this->logging) return forward_static_call("parent::addServers", func_get_args());
            $start = microtime(true);
            $name = 'addServers';
            $arguments = array($servers);
            $result = forward_static_call_array("parent::addServers", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getServerList( ) {
            if (!$this->logging) return forward_static_call("parent::getServerList", func_get_args());
            $start = microtime(true);
            $name = 'getServerList';
            $arguments = array();
            $result = forward_static_call_array("parent::getServerList", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getServerByKey( $server_key ) {
            if (!$this->logging) return forward_static_call("parent::getServerByKey", func_get_args());
            $start = microtime(true);
            $name = 'getServerByKey';
            $arguments = array($server_key);
            $result = forward_static_call_array("parent::getServerByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function flush( $delay = 0 ) {
            if (!$this->logging) return forward_static_call("parent::flush", func_get_args());
            $start = microtime(true);
            $name = 'flush';
            $arguments = array($delay);
            $result = forward_static_call_array("parent::flush", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getStats( ) {
            if (!$this->logging) return forward_static_call("parent::getStats", func_get_args());
            $start = microtime(true);
            $name = 'getStats';
            $arguments = array();
            $result = forward_static_call_array("parent::getStats", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getResultCode( ) {
            if (!$this->logging) return forward_static_call("parent::getResultCode", func_get_args());
            $start = microtime(true);
            $name = 'getResultCode';
            $arguments = array();
            $result = forward_static_call_array("parent::getResultCode", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getResultMessage( ) {
            if (!$this->logging) return forward_static_call("parent::getResultMessage", func_get_args());
            $start = microtime(true);
            $name = 'getResultMessage';
            $arguments = array();
            $result = forward_static_call_array("parent::getResultMessage", $arguments);
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
            forward_static_call("parent::__construct", $persistent_id);
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
            if (!$this->logging) return forward_static_call("parent::get", func_get_args());
            $start = microtime(true);
            $name = 'get';
            $arguments = array($key,$cache_cb,$cas_token);
            $result = forward_static_call_array("parent::get", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getByKey( $server_key, $key, $cache_cb = null, &$cas_token = null ) {
            if (!$this->logging) return forward_static_call("parent::getByKey", func_get_args());
            $start = microtime(true);
            $name = 'getByKey';
            $arguments = array($server_key,$key,$cache_cb,$cas_token);
            $result = forward_static_call_array("parent::getByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getMulti( array $keys, &$cas_tokens = null, $flags = null ) {
            if (!$this->logging) return forward_static_call("parent::getMulti", func_get_args());
            $start = microtime(true);
            $name = 'getMulti';
            $arguments = array($keys,$cas_tokens,$flags);
            $result = forward_static_call_array("parent::getMulti", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getMultiByKey( $server_key, array $keys, &$cas_tokens = null, $flags = null ) {
            if (!$this->logging) return forward_static_call("parent::getMultiByKey", func_get_args());
            $start = microtime(true);
            $name = 'getMultiByKey';
            $arguments = array($server_key,$keys,$cas_tokens,$flags);
            $result = forward_static_call_array("parent::getMultiByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getDelayed( array $keys, $with_cas = null, $value_cb = null ) {
            if (!$this->logging) return forward_static_call("parent::getDelayed", func_get_args());
            $start = microtime(true);
            $name = 'getDelayed';
            $arguments = array($keys,$with_cas,$value_cb);
            $result = forward_static_call_array("parent::getDelayed", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getDelayedByKey( $server_key, array $keys, $with_cas = null, $value_cb = null ) {
            if (!$this->logging) return forward_static_call("parent::getDelayedByKey", func_get_args());
            $start = microtime(true);
            $name = 'getDelayedByKey';
            $arguments = array($server_key,$keys,$with_cas,$value_cb);
            $result = forward_static_call_array("parent::getDelayedByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function fetch( ) {
            if (!$this->logging) return forward_static_call("parent::fetch", func_get_args());
            $start = microtime(true);
            $name = 'fetch';
            $arguments = array();
            $result = forward_static_call_array("parent::fetch", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function fetchAll( ) {
            if (!$this->logging) return forward_static_call("parent::fetchAll", func_get_args());
            $start = microtime(true);
            $name = 'fetchAll';
            $arguments = array();
            $result = forward_static_call_array("parent::fetchAll", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function set( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::set", func_get_args());
            $start = microtime(true);
            $name = 'set';
            $arguments = array($key,$value,$expiration);
            $result = forward_static_call_array("parent::set", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function touch( $key, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::touch", func_get_args());
            $start = microtime(true);
            $name = 'touch';
            $arguments = array($key,$expiration);
            $result = forward_static_call_array("parent::touch", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function touchbyKey( $server_key, $key, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::touchbyKey", func_get_args());
            $start = microtime(true);
            $name = 'touchbyKey';
            $arguments = array($server_key,$key,$expiration);
            $result = forward_static_call_array("parent::touchbyKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::setByKey", func_get_args());
            $start = microtime(true);
            $name = 'setByKey';
            $arguments = array($server_key,$key,$value,$expiration);
            $result = forward_static_call_array("parent::setByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setMulti( array $items, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::setMulti", func_get_args());
            $start = microtime(true);
            $name = 'setMulti';
            $arguments = array($items,$expiration);
            $result = forward_static_call_array("parent::setMulti", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setMultiByKey( $server_key, array $items, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::setMultiByKey", func_get_args());
            $start = microtime(true);
            $name = 'setMultiByKey';
            $arguments = array($server_key,$items,$expiration);
            $result = forward_static_call_array("parent::setMultiByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function cas( $token, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::cas", func_get_args());
            $start = microtime(true);
            $name = 'cas';
            $arguments = array($token,$key,$value,$expiration);
            $result = forward_static_call_array("parent::cas", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function casByKey( $token, $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::casByKey", func_get_args());
            $start = microtime(true);
            $name = 'casByKey';
            $arguments = array($token,$server_key,$key,$value,$expiration);
            $result = forward_static_call_array("parent::casByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function add( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::add", func_get_args());
            $start = microtime(true);
            $name = 'add';
            $arguments = array($key,$value,$expiration);
            $result = forward_static_call_array("parent::add", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::addByKey", func_get_args());
            $start = microtime(true);
            $name = 'addByKey';
            $arguments = array($server_key,$key,$value,$expiration);
            $result = forward_static_call_array("parent::addByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function append( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::append", func_get_args());
            $start = microtime(true);
            $name = 'append';
            $arguments = array($key,$value,$expiration);
            $result = forward_static_call_array("parent::append", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function appendByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::appendByKey", func_get_args());
            $start = microtime(true);
            $name = 'appendByKey';
            $arguments = array($server_key,$key,$value,$expiration);
            $result = forward_static_call_array("parent::appendByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function prepend( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::prepend", func_get_args());
            $start = microtime(true);
            $name = 'prepend';
            $arguments = array($key,$value,$expiration);
            $result = forward_static_call_array("parent::prepend", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function prependByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::prependByKey", func_get_args());
            $start = microtime(true);
            $name = 'prependByKey';
            $arguments = array($server_key,$key,$value,$expiration);
            $result = forward_static_call_array("parent::prependByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function replace( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::replace", func_get_args());
            $start = microtime(true);
            $name = 'replace';
            $arguments = array($key,$value,$expiration);
            $result = forward_static_call_array("parent::replace", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function replaceByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::replaceByKey", func_get_args());
            $start = microtime(true);
            $name = 'replaceByKey';
            $arguments = array($server_key,$key,$value,$expiration);
            $result = forward_static_call_array("parent::replaceByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function delete( $key, $time = 0 ) {
            if (!$this->logging) return forward_static_call("parent::delete", func_get_args());
            $start = microtime(true);
            $name = 'delete';
            $arguments = array($key,$time);
            $result = forward_static_call_array("parent::delete", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function deleteByKey( $server_key, $key, $time = 0 ) {
            if (!$this->logging) return forward_static_call("parent::deleteByKey", func_get_args());
            $start = microtime(true);
            $name = 'deleteByKey';
            $arguments = array($server_key,$key,$time);
            $result = forward_static_call_array("parent::deleteByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function deleteMulti( $keys, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::deleteMulti", func_get_args());
            $start = microtime(true);
            $name = 'deleteMulti';
            $arguments = array($keys,$expiration);
            $result = forward_static_call_array("parent::deleteMulti", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function deleteMultiByKey( $server_key, $keys, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::deleteMultiByKey", func_get_args());
            $start = microtime(true);
            $name = 'deleteMultiByKey';
            $arguments = array($server_key,$keys,$expiration);
            $result = forward_static_call_array("parent::deleteMultiByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function increment( $key, $offset = 1, $initial_value = 0, $expiry = 0 ) {
            if (!$this->logging) return forward_static_call("parent::increment", func_get_args());
            $start = microtime(true);
            $name = 'increment';
            $arguments = array($key,$offset,$initial_value,$expiry);
            $result = forward_static_call_array("parent::increment", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function incrementByKey( $server_key, $key, $offset = 1, $initial_value = 0, $expiry = 0 ) {
            if (!$this->logging) return forward_static_call("parent::incrementByKey", func_get_args());
            $start = microtime(true);
            $name = 'incrementByKey';
            $arguments = array($server_key,$key,$offset,$initial_value,$expiry);
            $result = forward_static_call_array("parent::incrementByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function decrement( $key, $offset = 1, $initial_value = 0, $expiry = 0 ) {
            if (!$this->logging) return forward_static_call("parent::decrement", func_get_args());
            $start = microtime(true);
            $name = 'decrement';
            $arguments = array($key,$offset,$initial_value,$expiry);
            $result = forward_static_call_array("parent::decrement", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function decrementByKey( $server_key, $key, $offset = 1, $initial_value = 0, $expiry = 0 ) {
            if (!$this->logging) return forward_static_call("parent::decrementByKey", func_get_args());
            $start = microtime(true);
            $name = 'decrementByKey';
            $arguments = array($server_key,$key,$offset,$initial_value,$expiry);
            $result = forward_static_call_array("parent::decrementByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getOption( $option ) {
            if (!$this->logging) return forward_static_call("parent::getOption", func_get_args());
            $start = microtime(true);
            $name = 'getOption';
            $arguments = array($option);
            $result = forward_static_call_array("parent::getOption", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setOption( $option, $value ) {
            if (!$this->logging) return forward_static_call("parent::setOption", func_get_args());
            $start = microtime(true);
            $name = 'setOption';
            $arguments = array($option,$value);
            $result = forward_static_call_array("parent::setOption", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setOptions( $options ) {
            if (!$this->logging) return forward_static_call("parent::setOptions", func_get_args());
            $start = microtime(true);
            $name = 'setOptions';
            $arguments = array($options);
            $result = forward_static_call_array("parent::setOptions", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addServer( $host, $port,  $weight = 0 ) {
            if (!$this->logging) return forward_static_call("parent::addServer", func_get_args());
            $start = microtime(true);
            $name = 'addServer';
            $arguments = array($host,$port,$weight);
            $result = forward_static_call_array("parent::addServer", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addServers( array $servers ) {
            if (!$this->logging) return forward_static_call("parent::addServers", func_get_args());
            $start = microtime(true);
            $name = 'addServers';
            $arguments = array($servers);
            $result = forward_static_call_array("parent::addServers", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getServerList( ) {
            if (!$this->logging) return forward_static_call("parent::getServerList", func_get_args());
            $start = microtime(true);
            $name = 'getServerList';
            $arguments = array();
            $result = forward_static_call_array("parent::getServerList", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getServerByKey( $server_key ) {
            if (!$this->logging) return forward_static_call("parent::getServerByKey", func_get_args());
            $start = microtime(true);
            $name = 'getServerByKey';
            $arguments = array($server_key);
            $result = forward_static_call_array("parent::getServerByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function flush( $delay = 0 ) {
            if (!$this->logging) return forward_static_call("parent::flush", func_get_args());
            $start = microtime(true);
            $name = 'flush';
            $arguments = array($delay);
            $result = forward_static_call_array("parent::flush", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getStats( ) {
            if (!$this->logging) return forward_static_call("parent::getStats", func_get_args());
            $start = microtime(true);
            $name = 'getStats';
            $arguments = array();
            $result = forward_static_call_array("parent::getStats", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getVersion( ) {
            if (!$this->logging) return forward_static_call("parent::getVersion", func_get_args());
            $start = microtime(true);
            $name = 'getVersion';
            $arguments = array();
            $result = forward_static_call_array("parent::getVersion", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getResultCode( ) {
            if (!$this->logging) return forward_static_call("parent::getResultCode", func_get_args());
            $start = microtime(true);
            $name = 'getResultCode';
            $arguments = array();
            $result = forward_static_call_array("parent::getResultCode", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getResultMessage( ) {
            if (!$this->logging) return forward_static_call("parent::getResultMessage", func_get_args());
            $start = microtime(true);
            $name = 'getResultMessage';
            $arguments = array();
            $result = forward_static_call_array("parent::getResultMessage", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function isPersistent( ) {
            if (!$this->logging) return forward_static_call("parent::isPersistent", func_get_args());
            $start = microtime(true);
            $name = 'isPersistent';
            $arguments = array();
            $result = forward_static_call_array("parent::isPersistent", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function isPristine( ) {
            if (!$this->logging) return forward_static_call("parent::isPristine", func_get_args());
            $start = microtime(true);
            $name = 'isPristine';
            $arguments = array();
            $result = forward_static_call_array("parent::isPristine", $arguments);
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
            forward_static_call("parent::__construct", $persistent_id);
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
            if (!$this->logging) return forward_static_call("parent::get", func_get_args());
            $start = microtime(true);
            $name = 'get';
            $arguments = array($key,$cache_cb,$cas_token);
            $result = forward_static_call_array("parent::get", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getByKey( $server_key, $key, $cache_cb = null, &$cas_token = null ) {
            if (!$this->logging) return forward_static_call("parent::getByKey", func_get_args());
            $start = microtime(true);
            $name = 'getByKey';
            $arguments = array($server_key,$key,$cache_cb,$cas_token);
            $result = forward_static_call_array("parent::getByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getMulti( array $keys, &$cas_tokens = null, $flags = null ) {
            if (!$this->logging) return forward_static_call("parent::getMulti", func_get_args());
            $start = microtime(true);
            $name = 'getMulti';
            $arguments = array($keys,$cas_tokens,$flags);
            $result = forward_static_call_array("parent::getMulti", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getMultiByKey( $server_key, array $keys, &$cas_tokens = null, $flags = null ) {
            if (!$this->logging) return forward_static_call("parent::getMultiByKey", func_get_args());
            $start = microtime(true);
            $name = 'getMultiByKey';
            $arguments = array($server_key,$keys,$cas_tokens,$flags);
            $result = forward_static_call_array("parent::getMultiByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getDelayed( array $keys, $with_cas = null, $value_cb = null ) {
            if (!$this->logging) return forward_static_call("parent::getDelayed", func_get_args());
            $start = microtime(true);
            $name = 'getDelayed';
            $arguments = array($keys,$with_cas,$value_cb);
            $result = forward_static_call_array("parent::getDelayed", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getDelayedByKey( $server_key, array $keys, $with_cas = null, $value_cb = null ) {
            if (!$this->logging) return forward_static_call("parent::getDelayedByKey", func_get_args());
            $start = microtime(true);
            $name = 'getDelayedByKey';
            $arguments = array($server_key,$keys,$with_cas,$value_cb);
            $result = forward_static_call_array("parent::getDelayedByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function fetch( ) {
            if (!$this->logging) return forward_static_call("parent::fetch", func_get_args());
            $start = microtime(true);
            $name = 'fetch';
            $arguments = array();
            $result = forward_static_call_array("parent::fetch", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function fetchAll( ) {
            if (!$this->logging) return forward_static_call("parent::fetchAll", func_get_args());
            $start = microtime(true);
            $name = 'fetchAll';
            $arguments = array();
            $result = forward_static_call_array("parent::fetchAll", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function set( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::set", func_get_args());
            $start = microtime(true);
            $name = 'set';
            $arguments = array($key,$value,$expiration);
            $result = forward_static_call_array("parent::set", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function touch( $key, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::touch", func_get_args());
            $start = microtime(true);
            $name = 'touch';
            $arguments = array($key,$expiration);
            $result = forward_static_call_array("parent::touch", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function touchbyKey( $server_key, $key, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::touchbyKey", func_get_args());
            $start = microtime(true);
            $name = 'touchbyKey';
            $arguments = array($server_key,$key,$expiration);
            $result = forward_static_call_array("parent::touchbyKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::setByKey", func_get_args());
            $start = microtime(true);
            $name = 'setByKey';
            $arguments = array($server_key,$key,$value,$expiration);
            $result = forward_static_call_array("parent::setByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setMulti( array $items, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::setMulti", func_get_args());
            $start = microtime(true);
            $name = 'setMulti';
            $arguments = array($items,$expiration);
            $result = forward_static_call_array("parent::setMulti", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setMultiByKey( $server_key, array $items, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::setMultiByKey", func_get_args());
            $start = microtime(true);
            $name = 'setMultiByKey';
            $arguments = array($server_key,$items,$expiration);
            $result = forward_static_call_array("parent::setMultiByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function cas( $token, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::cas", func_get_args());
            $start = microtime(true);
            $name = 'cas';
            $arguments = array($token,$key,$value,$expiration);
            $result = forward_static_call_array("parent::cas", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function casByKey( $token, $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::casByKey", func_get_args());
            $start = microtime(true);
            $name = 'casByKey';
            $arguments = array($token,$server_key,$key,$value,$expiration);
            $result = forward_static_call_array("parent::casByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function add( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::add", func_get_args());
            $start = microtime(true);
            $name = 'add';
            $arguments = array($key,$value,$expiration);
            $result = forward_static_call_array("parent::add", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::addByKey", func_get_args());
            $start = microtime(true);
            $name = 'addByKey';
            $arguments = array($server_key,$key,$value,$expiration);
            $result = forward_static_call_array("parent::addByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function append( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::append", func_get_args());
            $start = microtime(true);
            $name = 'append';
            $arguments = array($key,$value,$expiration);
            $result = forward_static_call_array("parent::append", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function appendByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::appendByKey", func_get_args());
            $start = microtime(true);
            $name = 'appendByKey';
            $arguments = array($server_key,$key,$value,$expiration);
            $result = forward_static_call_array("parent::appendByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function prepend( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::prepend", func_get_args());
            $start = microtime(true);
            $name = 'prepend';
            $arguments = array($key,$value,$expiration);
            $result = forward_static_call_array("parent::prepend", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function prependByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::prependByKey", func_get_args());
            $start = microtime(true);
            $name = 'prependByKey';
            $arguments = array($server_key,$key,$value,$expiration);
            $result = forward_static_call_array("parent::prependByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function replace( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::replace", func_get_args());
            $start = microtime(true);
            $name = 'replace';
            $arguments = array($key,$value,$expiration);
            $result = forward_static_call_array("parent::replace", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function replaceByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::replaceByKey", func_get_args());
            $start = microtime(true);
            $name = 'replaceByKey';
            $arguments = array($server_key,$key,$value,$expiration);
            $result = forward_static_call_array("parent::replaceByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function delete( $key, $time = 0 ) {
            if (!$this->logging) return forward_static_call("parent::delete", func_get_args());
            $start = microtime(true);
            $name = 'delete';
            $arguments = array($key,$time);
            $result = forward_static_call_array("parent::delete", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function deleteByKey( $server_key, $key, $time = 0 ) {
            if (!$this->logging) return forward_static_call("parent::deleteByKey", func_get_args());
            $start = microtime(true);
            $name = 'deleteByKey';
            $arguments = array($server_key,$key,$time);
            $result = forward_static_call_array("parent::deleteByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function deleteMulti( $keys, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::deleteMulti", func_get_args());
            $start = microtime(true);
            $name = 'deleteMulti';
            $arguments = array($keys,$expiration);
            $result = forward_static_call_array("parent::deleteMulti", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function deleteMultiByKey( $server_key, $keys, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::deleteMultiByKey", func_get_args());
            $start = microtime(true);
            $name = 'deleteMultiByKey';
            $arguments = array($server_key,$keys,$expiration);
            $result = forward_static_call_array("parent::deleteMultiByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function increment( $key, $offset = 1, $initial_value = 0, $expiry = 0 ) {
            if (!$this->logging) return forward_static_call("parent::increment", func_get_args());
            $start = microtime(true);
            $name = 'increment';
            $arguments = array($key,$offset,$initial_value,$expiry);
            $result = forward_static_call_array("parent::increment", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function incrementByKey( $server_key, $key, $offset = 1, $initial_value = 0, $expiry = 0 ) {
            if (!$this->logging) return forward_static_call("parent::incrementByKey", func_get_args());
            $start = microtime(true);
            $name = 'incrementByKey';
            $arguments = array($server_key,$key,$offset,$initial_value,$expiry);
            $result = forward_static_call_array("parent::incrementByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function decrement( $key, $offset = 1, $initial_value = 0, $expiry = 0 ) {
            if (!$this->logging) return forward_static_call("parent::decrement", func_get_args());
            $start = microtime(true);
            $name = 'decrement';
            $arguments = array($key,$offset,$initial_value,$expiry);
            $result = forward_static_call_array("parent::decrement", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function decrementByKey( $server_key, $key, $offset = 1, $initial_value = 0, $expiry = 0 ) {
            if (!$this->logging) return forward_static_call("parent::decrementByKey", func_get_args());
            $start = microtime(true);
            $name = 'decrementByKey';
            $arguments = array($server_key,$key,$offset,$initial_value,$expiry);
            $result = forward_static_call_array("parent::decrementByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getOption( $option ) {
            if (!$this->logging) return forward_static_call("parent::getOption", func_get_args());
            $start = microtime(true);
            $name = 'getOption';
            $arguments = array($option);
            $result = forward_static_call_array("parent::getOption", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setOption( $option, $value ) {
            if (!$this->logging) return forward_static_call("parent::setOption", func_get_args());
            $start = microtime(true);
            $name = 'setOption';
            $arguments = array($option,$value);
            $result = forward_static_call_array("parent::setOption", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setOptions( $options ) {
            if (!$this->logging) return forward_static_call("parent::setOptions", func_get_args());
            $start = microtime(true);
            $name = 'setOptions';
            $arguments = array($options);
            $result = forward_static_call_array("parent::setOptions", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addServer( $host, $port,  $weight = 0 ) {
            if (!$this->logging) return forward_static_call("parent::addServer", func_get_args());
            $start = microtime(true);
            $name = 'addServer';
            $arguments = array($host,$port,$weight);
            $result = forward_static_call_array("parent::addServer", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addServers( array $servers ) {
            if (!$this->logging) return forward_static_call("parent::addServers", func_get_args());
            $start = microtime(true);
            $name = 'addServers';
            $arguments = array($servers);
            $result = forward_static_call_array("parent::addServers", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getServerList( ) {
            if (!$this->logging) return forward_static_call("parent::getServerList", func_get_args());
            $start = microtime(true);
            $name = 'getServerList';
            $arguments = array();
            $result = forward_static_call_array("parent::getServerList", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getServerByKey( $server_key ) {
            if (!$this->logging) return forward_static_call("parent::getServerByKey", func_get_args());
            $start = microtime(true);
            $name = 'getServerByKey';
            $arguments = array($server_key);
            $result = forward_static_call_array("parent::getServerByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function flush( $delay = 0 ) {
            if (!$this->logging) return forward_static_call("parent::flush", func_get_args());
            $start = microtime(true);
            $name = 'flush';
            $arguments = array($delay);
            $result = forward_static_call_array("parent::flush", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getStats( ) {
            if (!$this->logging) return forward_static_call("parent::getStats", func_get_args());
            $start = microtime(true);
            $name = 'getStats';
            $arguments = array();
            $result = forward_static_call_array("parent::getStats", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getVersion( ) {
            if (!$this->logging) return forward_static_call("parent::getVersion", func_get_args());
            $start = microtime(true);
            $name = 'getVersion';
            $arguments = array();
            $result = forward_static_call_array("parent::getVersion", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getResultCode( ) {
            if (!$this->logging) return forward_static_call("parent::getResultCode", func_get_args());
            $start = microtime(true);
            $name = 'getResultCode';
            $arguments = array();
            $result = forward_static_call_array("parent::getResultCode", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getResultMessage( ) {
            if (!$this->logging) return forward_static_call("parent::getResultMessage", func_get_args());
            $start = microtime(true);
            $name = 'getResultMessage';
            $arguments = array();
            $result = forward_static_call_array("parent::getResultMessage", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function isPersistent( ) {
            if (!$this->logging) return forward_static_call("parent::isPersistent", func_get_args());
            $start = microtime(true);
            $name = 'isPersistent';
            $arguments = array();
            $result = forward_static_call_array("parent::isPersistent", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function isPristine( ) {
            if (!$this->logging) return forward_static_call("parent::isPristine", func_get_args());
            $start = microtime(true);
            $name = 'isPristine';
            $arguments = array();
            $result = forward_static_call_array("parent::isPristine", $arguments);
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
            forward_static_call("parent::__construct", $persistent_id);
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
            if (!$this->logging) return forward_static_call("parent::get", func_get_args());
            $start = microtime(true);
            $name = 'get';
            $arguments = array($key,$cache_cb,$cas_token,$udf_flags);
            $result = forward_static_call_array("parent::get", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getByKey( $server_key, $key, $cache_cb = null, &$cas_token = null, &$udf_flags = null ) {
            if (!$this->logging) return forward_static_call("parent::getByKey", func_get_args());
            $start = microtime(true);
            $name = 'getByKey';
            $arguments = array($server_key,$key,$cache_cb,$cas_token,$udf_flags);
            $result = forward_static_call_array("parent::getByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getMulti( array $keys, &$cas_tokens = null, $flags = null, &$udf_flags = null ) {
            if (!$this->logging) return forward_static_call("parent::getMulti", func_get_args());
            $start = microtime(true);
            $name = 'getMulti';
            $arguments = array($keys,$cas_tokens,$flags,$udf_flags);
            $result = forward_static_call_array("parent::getMulti", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getMultiByKey( $server_key, array $keys, &$cas_tokens = null, $flags = null, &$udf_flags = null ) {
            if (!$this->logging) return forward_static_call("parent::getMultiByKey", func_get_args());
            $start = microtime(true);
            $name = 'getMultiByKey';
            $arguments = array($server_key,$keys,$cas_tokens,$flags,$udf_flags);
            $result = forward_static_call_array("parent::getMultiByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getDelayed( array $keys, $with_cas = null, $value_cb = null ) {
            if (!$this->logging) return forward_static_call("parent::getDelayed", func_get_args());
            $start = microtime(true);
            $name = 'getDelayed';
            $arguments = array($keys,$with_cas,$value_cb);
            $result = forward_static_call_array("parent::getDelayed", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getDelayedByKey( $server_key, array $keys, $with_cas = null, $value_cb = null ) {
            if (!$this->logging) return forward_static_call("parent::getDelayedByKey", func_get_args());
            $start = microtime(true);
            $name = 'getDelayedByKey';
            $arguments = array($server_key,$keys,$with_cas,$value_cb);
            $result = forward_static_call_array("parent::getDelayedByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function fetch( ) {
            if (!$this->logging) return forward_static_call("parent::fetch", func_get_args());
            $start = microtime(true);
            $name = 'fetch';
            $arguments = array();
            $result = forward_static_call_array("parent::fetch", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function fetchAll( ) {
            if (!$this->logging) return forward_static_call("parent::fetchAll", func_get_args());
            $start = microtime(true);
            $name = 'fetchAll';
            $arguments = array();
            $result = forward_static_call_array("parent::fetchAll", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function set( $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return forward_static_call("parent::set", func_get_args());
            $start = microtime(true);
            $name = 'set';
            $arguments = array($key,$value,$expiration,$udf_flags);
            $result = forward_static_call_array("parent::set", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function touch( $key, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::touch", func_get_args());
            $start = microtime(true);
            $name = 'touch';
            $arguments = array($key,$expiration);
            $result = forward_static_call_array("parent::touch", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function touchbyKey( $server_key, $key, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::touchbyKey", func_get_args());
            $start = microtime(true);
            $name = 'touchbyKey';
            $arguments = array($server_key,$key,$expiration);
            $result = forward_static_call_array("parent::touchbyKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setByKey( $server_key, $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return forward_static_call("parent::setByKey", func_get_args());
            $start = microtime(true);
            $name = 'setByKey';
            $arguments = array($server_key,$key,$value,$expiration,$udf_flags);
            $result = forward_static_call_array("parent::setByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setMulti( array $items, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return forward_static_call("parent::setMulti", func_get_args());
            $start = microtime(true);
            $name = 'setMulti';
            $arguments = array($items,$expiration,$udf_flags);
            $result = forward_static_call_array("parent::setMulti", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setMultiByKey( $server_key, array $items, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return forward_static_call("parent::setMultiByKey", func_get_args());
            $start = microtime(true);
            $name = 'setMultiByKey';
            $arguments = array($server_key,$items,$expiration,$udf_flags);
            $result = forward_static_call_array("parent::setMultiByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function cas( $token, $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return forward_static_call("parent::cas", func_get_args());
            $start = microtime(true);
            $name = 'cas';
            $arguments = array($token,$key,$value,$expiration,$udf_flags);
            $result = forward_static_call_array("parent::cas", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function casByKey( $token, $server_key, $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return forward_static_call("parent::casByKey", func_get_args());
            $start = microtime(true);
            $name = 'casByKey';
            $arguments = array($token,$server_key,$key,$value,$expiration,$udf_flags);
            $result = forward_static_call_array("parent::casByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function add( $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return forward_static_call("parent::add", func_get_args());
            $start = microtime(true);
            $name = 'add';
            $arguments = array($key,$value,$expiration,$udf_flags);
            $result = forward_static_call_array("parent::add", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addByKey( $server_key, $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return forward_static_call("parent::addByKey", func_get_args());
            $start = microtime(true);
            $name = 'addByKey';
            $arguments = array($server_key,$key,$value,$expiration,$udf_flags);
            $result = forward_static_call_array("parent::addByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function append( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::append", func_get_args());
            $start = microtime(true);
            $name = 'append';
            $arguments = array($key,$value,$expiration);
            $result = forward_static_call_array("parent::append", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function appendByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::appendByKey", func_get_args());
            $start = microtime(true);
            $name = 'appendByKey';
            $arguments = array($server_key,$key,$value,$expiration);
            $result = forward_static_call_array("parent::appendByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function prepend( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::prepend", func_get_args());
            $start = microtime(true);
            $name = 'prepend';
            $arguments = array($key,$value,$expiration);
            $result = forward_static_call_array("parent::prepend", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function prependByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::prependByKey", func_get_args());
            $start = microtime(true);
            $name = 'prependByKey';
            $arguments = array($server_key,$key,$value,$expiration);
            $result = forward_static_call_array("parent::prependByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function replace( $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return forward_static_call("parent::replace", func_get_args());
            $start = microtime(true);
            $name = 'replace';
            $arguments = array($key,$value,$expiration,$udf_flags);
            $result = forward_static_call_array("parent::replace", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function replaceByKey( $server_key, $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return forward_static_call("parent::replaceByKey", func_get_args());
            $start = microtime(true);
            $name = 'replaceByKey';
            $arguments = array($server_key,$key,$value,$expiration,$udf_flags);
            $result = forward_static_call_array("parent::replaceByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function delete( $key, $time = 0 ) {
            if (!$this->logging) return forward_static_call("parent::delete", func_get_args());
            $start = microtime(true);
            $name = 'delete';
            $arguments = array($key,$time);
            $result = forward_static_call_array("parent::delete", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function deleteByKey( $server_key, $key, $time = 0 ) {
            if (!$this->logging) return forward_static_call("parent::deleteByKey", func_get_args());
            $start = microtime(true);
            $name = 'deleteByKey';
            $arguments = array($server_key,$key,$time);
            $result = forward_static_call_array("parent::deleteByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function deleteMulti( $keys, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::deleteMulti", func_get_args());
            $start = microtime(true);
            $name = 'deleteMulti';
            $arguments = array($keys,$expiration);
            $result = forward_static_call_array("parent::deleteMulti", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function deleteMultiByKey( $server_key, $keys, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::deleteMultiByKey", func_get_args());
            $start = microtime(true);
            $name = 'deleteMultiByKey';
            $arguments = array($server_key,$keys,$expiration);
            $result = forward_static_call_array("parent::deleteMultiByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function increment( $key, $offset = 1, $initial_value = 0, $expiry = 0) {
            if (!$this->logging) return forward_static_call("parent::increment", func_get_args());
            $start = microtime(true);
            $name = 'increment';
            $arguments = array($key,$offset,$initial_value,$expiry);
            $result = forward_static_call_array("parent::increment", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function incrementByKey( $server_key, $key, $offset = 1, $initial_value = 0, $expiry = 0 ) {
            if (!$this->logging) return forward_static_call("parent::incrementByKey", func_get_args());
            $start = microtime(true);
            $name = 'incrementByKey';
            $arguments = array($server_key,$key,$offset,$initial_value,$expiry);
            $result = forward_static_call_array("parent::incrementByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function decrement( $key, $offset = 1, $initial_value = 0, $expiry = 0) {
            if (!$this->logging) return forward_static_call("parent::decrement", func_get_args());
            $start = microtime(true);
            $name = 'decrement';
            $arguments = array($key,$offset,$initial_value,$expiry);
            $result = forward_static_call_array("parent::decrement", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function decrementByKey( $server_key, $key, $offset = 1, $initial_value = 0, $expiry = 0 ) {
            if (!$this->logging) return forward_static_call("parent::decrementByKey", func_get_args());
            $start = microtime(true);
            $name = 'decrementByKey';
            $arguments = array($server_key,$key,$offset,$initial_value,$expiry);
            $result = forward_static_call_array("parent::decrementByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getOption( $option ) {
            if (!$this->logging) return forward_static_call("parent::getOption", func_get_args());
            $start = microtime(true);
            $name = 'getOption';
            $arguments = array($option);
            $result = forward_static_call_array("parent::getOption", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setOption( $option, $value ) {
            if (!$this->logging) return forward_static_call("parent::setOption", func_get_args());
            $start = microtime(true);
            $name = 'setOption';
            $arguments = array($option,$value);
            $result = forward_static_call_array("parent::setOption", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setOptions( $options ) {
            if (!$this->logging) return forward_static_call("parent::setOptions", func_get_args());
            $start = microtime(true);
            $name = 'setOptions';
            $arguments = array($options);
            $result = forward_static_call_array("parent::setOptions", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setBucket( $host_map, $forward_map, $replicas ) {
            if (!$this->logging) return forward_static_call("parent::setBucket", func_get_args());
            $start = microtime(true);
            $name = 'setBucket';
            $arguments = array($host_map,$forward_map,$replicas);
            $result = forward_static_call_array("parent::setBucket", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addServer( $host, $port,  $weight = 0 ) {
            if (!$this->logging) return forward_static_call("parent::addServer", func_get_args());
            $start = microtime(true);
            $name = 'addServer';
            $arguments = array($host,$port,$weight);
            $result = forward_static_call_array("parent::addServer", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addServers( array $servers ) {
            if (!$this->logging) return forward_static_call("parent::addServers", func_get_args());
            $start = microtime(true);
            $name = 'addServers';
            $arguments = array($servers);
            $result = forward_static_call_array("parent::addServers", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getServerList( ) {
            if (!$this->logging) return forward_static_call("parent::getServerList", func_get_args());
            $start = microtime(true);
            $name = 'getServerList';
            $arguments = array();
            $result = forward_static_call_array("parent::getServerList", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getServerByKey( $server_key ) {
            if (!$this->logging) return forward_static_call("parent::getServerByKey", func_get_args());
            $start = microtime(true);
            $name = 'getServerByKey';
            $arguments = array($server_key);
            $result = forward_static_call_array("parent::getServerByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getLastErrorMessage( ) {
            if (!$this->logging) return forward_static_call("parent::getLastErrorMessage", func_get_args());
            $start = microtime(true);
            $name = 'getLastErrorMessage';
            $arguments = array();
            $result = forward_static_call_array("parent::getLastErrorMessage", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getLastErrorCode( ) {
            if (!$this->logging) return forward_static_call("parent::getLastErrorCode", func_get_args());
            $start = microtime(true);
            $name = 'getLastErrorCode';
            $arguments = array();
            $result = forward_static_call_array("parent::getLastErrorCode", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getLastErrorErrno( ) {
            if (!$this->logging) return forward_static_call("parent::getLastErrorErrno", func_get_args());
            $start = microtime(true);
            $name = 'getLastErrorErrno';
            $arguments = array();
            $result = forward_static_call_array("parent::getLastErrorErrno", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getLastDisconnectedServer( ) {
            if (!$this->logging) return forward_static_call("parent::getLastDisconnectedServer", func_get_args());
            $start = microtime(true);
            $name = 'getLastDisconnectedServer';
            $arguments = array();
            $result = forward_static_call_array("parent::getLastDisconnectedServer", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function flush( $delay = 0 ) {
            if (!$this->logging) return forward_static_call("parent::flush", func_get_args());
            $start = microtime(true);
            $name = 'flush';
            $arguments = array($delay);
            $result = forward_static_call_array("parent::flush", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getStats( ) {
            if (!$this->logging) return forward_static_call("parent::getStats", func_get_args());
            $start = microtime(true);
            $name = 'getStats';
            $arguments = array();
            $result = forward_static_call_array("parent::getStats", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getVersion( ) {
            if (!$this->logging) return forward_static_call("parent::getVersion", func_get_args());
            $start = microtime(true);
            $name = 'getVersion';
            $arguments = array();
            $result = forward_static_call_array("parent::getVersion", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getResultCode( ) {
            if (!$this->logging) return forward_static_call("parent::getResultCode", func_get_args());
            $start = microtime(true);
            $name = 'getResultCode';
            $arguments = array();
            $result = forward_static_call_array("parent::getResultCode", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getResultMessage( ) {
            if (!$this->logging) return forward_static_call("parent::getResultMessage", func_get_args());
            $start = microtime(true);
            $name = 'getResultMessage';
            $arguments = array();
            $result = forward_static_call_array("parent::getResultMessage", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function isPersistent( ) {
            if (!$this->logging) return forward_static_call("parent::isPersistent", func_get_args());
            $start = microtime(true);
            $name = 'isPersistent';
            $arguments = array();
            $result = forward_static_call_array("parent::isPersistent", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function isPristine( ) {
            if (!$this->logging) return forward_static_call("parent::isPristine", func_get_args());
            $start = microtime(true);
            $name = 'isPristine';
            $arguments = array();
            $result = forward_static_call_array("parent::isPristine", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setSaslAuthData( $username, $password ) {
            if (!$this->logging) return forward_static_call("parent::setSaslAuthData", func_get_args());
            $start = microtime(true);
            $name = 'setSaslAuthData';
            $arguments = array($username,$password);
            $result = forward_static_call_array("parent::setSaslAuthData", $arguments);
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
            forward_static_call("parent::__construct", $persistent_id);
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
            if (!$this->logging) return forward_static_call("parent::get", func_get_args());
            $start = microtime(true);
            $name = 'get';
            $arguments = array($key,$cache_cb,$cas_token,$udf_flags);
            $result = forward_static_call_array("parent::get", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getByKey( $server_key, $key, $cache_cb = null, &$cas_token = null, &$udf_flags = null ) {
            if (!$this->logging) return forward_static_call("parent::getByKey", func_get_args());
            $start = microtime(true);
            $name = 'getByKey';
            $arguments = array($server_key,$key,$cache_cb,$cas_token,$udf_flags);
            $result = forward_static_call_array("parent::getByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getMulti( array $keys, &$cas_tokens = null, $flags = null, &$udf_flags = null ) {
            if (!$this->logging) return forward_static_call("parent::getMulti", func_get_args());
            $start = microtime(true);
            $name = 'getMulti';
            $arguments = array($keys,$cas_tokens,$flags,$udf_flags);
            $result = forward_static_call_array("parent::getMulti", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getMultiByKey( $server_key, array $keys, &$cas_tokens = null, $flags = null, &$udf_flags = null ) {
            if (!$this->logging) return forward_static_call("parent::getMultiByKey", func_get_args());
            $start = microtime(true);
            $name = 'getMultiByKey';
            $arguments = array($server_key,$keys,$cas_tokens,$flags,$udf_flags);
            $result = forward_static_call_array("parent::getMultiByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getDelayed( array $keys, $with_cas = null, $value_cb = null ) {
            if (!$this->logging) return forward_static_call("parent::getDelayed", func_get_args());
            $start = microtime(true);
            $name = 'getDelayed';
            $arguments = array($keys,$with_cas,$value_cb);
            $result = forward_static_call_array("parent::getDelayed", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getDelayedByKey( $server_key, array $keys, $with_cas = null, $value_cb = null ) {
            if (!$this->logging) return forward_static_call("parent::getDelayedByKey", func_get_args());
            $start = microtime(true);
            $name = 'getDelayedByKey';
            $arguments = array($server_key,$keys,$with_cas,$value_cb);
            $result = forward_static_call_array("parent::getDelayedByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function fetch( ) {
            if (!$this->logging) return forward_static_call("parent::fetch", func_get_args());
            $start = microtime(true);
            $name = 'fetch';
            $arguments = array();
            $result = forward_static_call_array("parent::fetch", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function fetchAll( ) {
            if (!$this->logging) return forward_static_call("parent::fetchAll", func_get_args());
            $start = microtime(true);
            $name = 'fetchAll';
            $arguments = array();
            $result = forward_static_call_array("parent::fetchAll", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function set( $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return forward_static_call("parent::set", func_get_args());
            $start = microtime(true);
            $name = 'set';
            $arguments = array($key,$value,$expiration,$udf_flags);
            $result = forward_static_call_array("parent::set", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function touch( $key, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::touch", func_get_args());
            $start = microtime(true);
            $name = 'touch';
            $arguments = array($key,$expiration);
            $result = forward_static_call_array("parent::touch", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function touchbyKey( $server_key, $key, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::touchbyKey", func_get_args());
            $start = microtime(true);
            $name = 'touchbyKey';
            $arguments = array($server_key,$key,$expiration);
            $result = forward_static_call_array("parent::touchbyKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setByKey( $server_key, $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return forward_static_call("parent::setByKey", func_get_args());
            $start = microtime(true);
            $name = 'setByKey';
            $arguments = array($server_key,$key,$value,$expiration,$udf_flags);
            $result = forward_static_call_array("parent::setByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setMulti( array $items, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return forward_static_call("parent::setMulti", func_get_args());
            $start = microtime(true);
            $name = 'setMulti';
            $arguments = array($items,$expiration,$udf_flags);
            $result = forward_static_call_array("parent::setMulti", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setMultiByKey( $server_key, array $items, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return forward_static_call("parent::setMultiByKey", func_get_args());
            $start = microtime(true);
            $name = 'setMultiByKey';
            $arguments = array($server_key,$items,$expiration,$udf_flags);
            $result = forward_static_call_array("parent::setMultiByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function cas( $token, $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return forward_static_call("parent::cas", func_get_args());
            $start = microtime(true);
            $name = 'cas';
            $arguments = array($token,$key,$value,$expiration,$udf_flags);
            $result = forward_static_call_array("parent::cas", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function casByKey( $token, $server_key, $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return forward_static_call("parent::casByKey", func_get_args());
            $start = microtime(true);
            $name = 'casByKey';
            $arguments = array($token,$server_key,$key,$value,$expiration,$udf_flags);
            $result = forward_static_call_array("parent::casByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function add( $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return forward_static_call("parent::add", func_get_args());
            $start = microtime(true);
            $name = 'add';
            $arguments = array($key,$value,$expiration,$udf_flags);
            $result = forward_static_call_array("parent::add", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addByKey( $server_key, $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return forward_static_call("parent::addByKey", func_get_args());
            $start = microtime(true);
            $name = 'addByKey';
            $arguments = array($server_key,$key,$value,$expiration,$udf_flags);
            $result = forward_static_call_array("parent::addByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function append( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::append", func_get_args());
            $start = microtime(true);
            $name = 'append';
            $arguments = array($key,$value,$expiration);
            $result = forward_static_call_array("parent::append", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function appendByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::appendByKey", func_get_args());
            $start = microtime(true);
            $name = 'appendByKey';
            $arguments = array($server_key,$key,$value,$expiration);
            $result = forward_static_call_array("parent::appendByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function prepend( $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::prepend", func_get_args());
            $start = microtime(true);
            $name = 'prepend';
            $arguments = array($key,$value,$expiration);
            $result = forward_static_call_array("parent::prepend", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function prependByKey( $server_key, $key, $value, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::prependByKey", func_get_args());
            $start = microtime(true);
            $name = 'prependByKey';
            $arguments = array($server_key,$key,$value,$expiration);
            $result = forward_static_call_array("parent::prependByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function replace( $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return forward_static_call("parent::replace", func_get_args());
            $start = microtime(true);
            $name = 'replace';
            $arguments = array($key,$value,$expiration,$udf_flags);
            $result = forward_static_call_array("parent::replace", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function replaceByKey( $server_key, $key, $value, $expiration = 0, $udf_flags = 0 ) {
            if (!$this->logging) return forward_static_call("parent::replaceByKey", func_get_args());
            $start = microtime(true);
            $name = 'replaceByKey';
            $arguments = array($server_key,$key,$value,$expiration,$udf_flags);
            $result = forward_static_call_array("parent::replaceByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function delete( $key, $time = 0 ) {
            if (!$this->logging) return forward_static_call("parent::delete", func_get_args());
            $start = microtime(true);
            $name = 'delete';
            $arguments = array($key,$time);
            $result = forward_static_call_array("parent::delete", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function deleteByKey( $server_key, $key, $time = 0 ) {
            if (!$this->logging) return forward_static_call("parent::deleteByKey", func_get_args());
            $start = microtime(true);
            $name = 'deleteByKey';
            $arguments = array($server_key,$key,$time);
            $result = forward_static_call_array("parent::deleteByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function deleteMulti( $keys, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::deleteMulti", func_get_args());
            $start = microtime(true);
            $name = 'deleteMulti';
            $arguments = array($keys,$expiration);
            $result = forward_static_call_array("parent::deleteMulti", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function deleteMultiByKey( $server_key, $keys, $expiration = 0 ) {
            if (!$this->logging) return forward_static_call("parent::deleteMultiByKey", func_get_args());
            $start = microtime(true);
            $name = 'deleteMultiByKey';
            $arguments = array($server_key,$keys,$expiration);
            $result = forward_static_call_array("parent::deleteMultiByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function increment( $key, $offset = 1, $initial_value = 0, $expiry = 0) {
            if (!$this->logging) return forward_static_call("parent::increment", func_get_args());
            $start = microtime(true);
            $name = 'increment';
            $arguments = array($key,$offset,$initial_value,$expiry);
            $result = forward_static_call_array("parent::increment", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function incrementByKey( $server_key, $key, $offset = 1, $initial_value = 0, $expiry = 0 ) {
            if (!$this->logging) return forward_static_call("parent::incrementByKey", func_get_args());
            $start = microtime(true);
            $name = 'incrementByKey';
            $arguments = array($server_key,$key,$offset,$initial_value,$expiry);
            $result = forward_static_call_array("parent::incrementByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function decrement( $key, $offset = 1, $initial_value = 0, $expiry = 0) {
            if (!$this->logging) return forward_static_call("parent::decrement", func_get_args());
            $start = microtime(true);
            $name = 'decrement';
            $arguments = array($key,$offset,$initial_value,$expiry);
            $result = forward_static_call_array("parent::decrement", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function decrementByKey( $server_key, $key, $offset = 1, $initial_value = 0, $expiry = 0 ) {
            if (!$this->logging) return forward_static_call("parent::decrementByKey", func_get_args());
            $start = microtime(true);
            $name = 'decrementByKey';
            $arguments = array($server_key,$key,$offset,$initial_value,$expiry);
            $result = forward_static_call_array("parent::decrementByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getOption( $option ) {
            if (!$this->logging) return forward_static_call("parent::getOption", func_get_args());
            $start = microtime(true);
            $name = 'getOption';
            $arguments = array($option);
            $result = forward_static_call_array("parent::getOption", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setOption( $option, $value ) {
            if (!$this->logging) return forward_static_call("parent::setOption", func_get_args());
            $start = microtime(true);
            $name = 'setOption';
            $arguments = array($option,$value);
            $result = forward_static_call_array("parent::setOption", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setOptions( $options ) {
            if (!$this->logging) return forward_static_call("parent::setOptions", func_get_args());
            $start = microtime(true);
            $name = 'setOptions';
            $arguments = array($options);
            $result = forward_static_call_array("parent::setOptions", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setBucket( $host_map, $forward_map, $replicas ) {
            if (!$this->logging) return forward_static_call("parent::setBucket", func_get_args());
            $start = microtime(true);
            $name = 'setBucket';
            $arguments = array($host_map,$forward_map,$replicas);
            $result = forward_static_call_array("parent::setBucket", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addServer( $host, $port,  $weight = 0 ) {
            if (!$this->logging) return forward_static_call("parent::addServer", func_get_args());
            $start = microtime(true);
            $name = 'addServer';
            $arguments = array($host,$port,$weight);
            $result = forward_static_call_array("parent::addServer", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function addServers( array $servers ) {
            if (!$this->logging) return forward_static_call("parent::addServers", func_get_args());
            $start = microtime(true);
            $name = 'addServers';
            $arguments = array($servers);
            $result = forward_static_call_array("parent::addServers", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getServerList( ) {
            if (!$this->logging) return forward_static_call("parent::getServerList", func_get_args());
            $start = microtime(true);
            $name = 'getServerList';
            $arguments = array();
            $result = forward_static_call_array("parent::getServerList", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getServerByKey( $server_key ) {
            if (!$this->logging) return forward_static_call("parent::getServerByKey", func_get_args());
            $start = microtime(true);
            $name = 'getServerByKey';
            $arguments = array($server_key);
            $result = forward_static_call_array("parent::getServerByKey", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getLastErrorMessage( ) {
            if (!$this->logging) return forward_static_call("parent::getLastErrorMessage", func_get_args());
            $start = microtime(true);
            $name = 'getLastErrorMessage';
            $arguments = array();
            $result = forward_static_call_array("parent::getLastErrorMessage", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getLastErrorCode( ) {
            if (!$this->logging) return forward_static_call("parent::getLastErrorCode", func_get_args());
            $start = microtime(true);
            $name = 'getLastErrorCode';
            $arguments = array();
            $result = forward_static_call_array("parent::getLastErrorCode", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getLastErrorErrno( ) {
            if (!$this->logging) return forward_static_call("parent::getLastErrorErrno", func_get_args());
            $start = microtime(true);
            $name = 'getLastErrorErrno';
            $arguments = array();
            $result = forward_static_call_array("parent::getLastErrorErrno", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getLastDisconnectedServer( ) {
            if (!$this->logging) return forward_static_call("parent::getLastDisconnectedServer", func_get_args());
            $start = microtime(true);
            $name = 'getLastDisconnectedServer';
            $arguments = array();
            $result = forward_static_call_array("parent::getLastDisconnectedServer", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function flush( $delay = 0 ) {
            if (!$this->logging) return forward_static_call("parent::flush", func_get_args());
            $start = microtime(true);
            $name = 'flush';
            $arguments = array($delay);
            $result = forward_static_call_array("parent::flush", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getStats( ) {
            if (!$this->logging) return forward_static_call("parent::getStats", func_get_args());
            $start = microtime(true);
            $name = 'getStats';
            $arguments = array();
            $result = forward_static_call_array("parent::getStats", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getVersion( ) {
            if (!$this->logging) return forward_static_call("parent::getVersion", func_get_args());
            $start = microtime(true);
            $name = 'getVersion';
            $arguments = array();
            $result = forward_static_call_array("parent::getVersion", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getResultCode( ) {
            if (!$this->logging) return forward_static_call("parent::getResultCode", func_get_args());
            $start = microtime(true);
            $name = 'getResultCode';
            $arguments = array();
            $result = forward_static_call_array("parent::getResultCode", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getResultMessage( ) {
            if (!$this->logging) return forward_static_call("parent::getResultMessage", func_get_args());
            $start = microtime(true);
            $name = 'getResultMessage';
            $arguments = array();
            $result = forward_static_call_array("parent::getResultMessage", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function isPersistent( ) {
            if (!$this->logging) return forward_static_call("parent::isPersistent", func_get_args());
            $start = microtime(true);
            $name = 'isPersistent';
            $arguments = array();
            $result = forward_static_call_array("parent::isPersistent", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function isPristine( ) {
            if (!$this->logging) return forward_static_call("parent::isPristine", func_get_args());
            $start = microtime(true);
            $name = 'isPristine';
            $arguments = array();
            $result = forward_static_call_array("parent::isPristine", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setSaslAuthData( $username, $password ) {
            if (!$this->logging) return forward_static_call("parent::setSaslAuthData", func_get_args());
            $start = microtime(true);
            $name = 'setSaslAuthData';
            $arguments = array($username,$password);
            $result = forward_static_call_array("parent::setSaslAuthData", $arguments);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
    }
} else {
    throw new \Exception('LswMemcacheBundle does not support version '.$extension->getVersion().' of the memcached extension.');
}
