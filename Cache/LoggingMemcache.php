<?php
namespace Lsw\MemcacheBundle\Cache;

$extension = new \ReflectionExtension('memcache');
if ($extension->getVersion()=='3.0.8') {
    class LoggingMemcache extends \Memcache implements MemcacheInterface, LoggingMemcacheInterface {
        public function __construct($logging) {
            $this->calls = array();
            $this->logging = $logging;
        }
        private $calls;
        private $logging;
        public function getLoggedCalls() {
            return $this->calls;
        }
        private function logCall($start, $result) {
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function connect($host,$port=null,$timeout=null) {
            if (!$this->logging) return parent::connect($host,$port,$timeout);
            $start = microtime(true);
            $name = 'connect';
            $arguments = array($host,$port,$timeout);
            $result = parent::connect($host,$port,$timeout);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function pconnect($host,$port=null,$timeout=null) {
            if (!$this->logging) return parent::pconnect($host,$port,$timeout);
            $start = microtime(true);
            $name = 'pconnect';
            $arguments = array($host,$port,$timeout);
            $result = parent::pconnect($host,$port,$timeout);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function add_server($host,$port=null,$persistent=null,$weight=null,$timeout=null,$retry_interval=null,$status=null,$failure_callback=null) {
            if (!$this->logging) return parent::add_server($host,$port,$persistent,$weight,$timeout,$retry_interval,$status,$failure_callback);
            $start = microtime(true);
            $name = 'add_server';
            $arguments = array($host,$port,$persistent,$weight,$timeout,$retry_interval,$status,$failure_callback);
            $result = parent::add_server($host,$port,$persistent,$weight,$timeout,$retry_interval,$status,$failure_callback);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function set_server_params($host,$port=null,$timeout=null,$retry_interval=null,$status=null,$failure_callback=null) {
            if (!$this->logging) return parent::set_server_params($host,$port,$timeout,$retry_interval,$status,$failure_callback);
            $start = microtime(true);
            $name = 'set_server_params';
            $arguments = array($host,$port,$timeout,$retry_interval,$status,$failure_callback);
            $result = parent::set_server_params($host,$port,$timeout,$retry_interval,$status,$failure_callback);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function set_failure_callback($failure_callback) {
            if (!$this->logging) return parent::set_failure_callback($failure_callback);
            $start = microtime(true);
            $name = 'set_failure_callback';
            $arguments = array($failure_callback);
            $result = parent::set_failure_callback($failure_callback);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function get_server_status($host,$port=null) {
            if (!$this->logging) return parent::get_server_status($host,$port);
            $start = microtime(true);
            $name = 'get_server_status';
            $arguments = array($host,$port);
            $result = parent::get_server_status($host,$port);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function get_version() {
            if (!$this->logging) return parent::get_version();
            $start = microtime(true);
            $name = 'get_version';
            $arguments = array();
            $result = parent::get_version();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function add($key,$var=null,$flag=null,$exptime=null) {
            if (!$this->logging) return parent::add($key,$var,$flag,$exptime);
            $start = microtime(true);
            $name = 'add';
            $arguments = array($key,$var,$flag,$exptime);
            $result = parent::add($key,$var,$flag,$exptime);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function set($key,$var=null,$flag=null,$exptime=null) {
            if (!$this->logging) return parent::set($key,$var,$flag,$exptime);
            $start = microtime(true);
            $name = 'set';
            $arguments = array($key,$var,$flag,$exptime);
            $result = parent::set($key,$var,$flag,$exptime);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function replace($key,$var=null,$flag=null,$exptime=null) {
            if (!$this->logging) return parent::replace($key,$var,$flag,$exptime);
            $start = microtime(true);
            $name = 'replace';
            $arguments = array($key,$var,$flag,$exptime);
            $result = parent::replace($key,$var,$flag,$exptime);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function cas($key,$var=null,$flag=null,$exptime=null,$cas=null) {
            if (!$this->logging) return parent::cas($key,$var,$flag,$exptime,$cas);
            $start = microtime(true);
            $name = 'cas';
            $arguments = array($key,$var,$flag,$exptime,$cas);
            $result = parent::cas($key,$var,$flag,$exptime,$cas);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function prepend($key,$var=null,$flag=null,$exptime=null) {
            if (!$this->logging) return parent::prepend($key,$var,$flag,$exptime);
            $start = microtime(true);
            $name = 'prepend';
            $arguments = array($key,$var,$flag,$exptime);
            $result = parent::prepend($key,$var,$flag,$exptime);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function get($key,&$flags=null,&$cas=null) {
            if (!$this->logging) return parent::get($key,$flags,$cas);
            $start = microtime(true);
            $name = 'get';
            $arguments = array($key,$flags,$cas);
            $result = parent::get($key,$flags,$cas);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function get_stats($type=null,$slabid=null,$limit=null) {
            if (!$this->logging) return parent::get_stats($type,$slabid,$limit);
            $start = microtime(true);
            $name = 'get_stats';
            $arguments = array($type,$slabid,$limit);
            $result = parent::get_stats($type,$slabid,$limit);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function get_extended_stats($type=null,$slabid=null,$limit=null) {
            if (!$this->logging) return parent::get_extended_stats($type,$slabid,$limit);
            $start = microtime(true);
            $name = 'get_extended_stats';
            $arguments = array($type,$slabid,$limit);
            $result = parent::get_extended_stats($type,$slabid,$limit);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function set_compress_threshold($threshold,$min_savings=null) {
            if (!$this->logging) return parent::set_compress_threshold($threshold,$min_savings);
            $start = microtime(true);
            $name = 'set_compress_threshold';
            $arguments = array($threshold,$min_savings);
            $result = parent::set_compress_threshold($threshold,$min_savings);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function delete($key,$exptime=null) {
            if (!$this->logging) return parent::delete($key,$exptime);
            $start = microtime(true);
            $name = 'delete';
            $arguments = array($key,$exptime);
            $result = parent::delete($key,$exptime);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function increment($key,$value=null,$defval=null,$exptime=null) {
            if (!$this->logging) return parent::increment($key,$value,$defval,$exptime);
            $start = microtime(true);
            $name = 'increment';
            $arguments = array($key,$value,$defval,$exptime);
            $result = parent::increment($key,$value,$defval,$exptime);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function decrement($key,$value=null,$defval=null,$exptime=null) {
            if (!$this->logging) return parent::decrement($key,$value,$defval,$exptime);
            $start = microtime(true);
            $name = 'decrement';
            $arguments = array($key,$value,$defval,$exptime);
            $result = parent::decrement($key,$value,$defval,$exptime);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function close() {
            if (!$this->logging) return parent::close();
            $start = microtime(true);
            $name = 'close';
            $arguments = array();
            $result = parent::close();
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function flush($delay=null) {
            if (!$this->logging) return parent::flush($delay);
            $start = microtime(true);
            $name = 'flush';
            $arguments = array($delay);
            $result = parent::flush($delay);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function debug($onoff) {
            if (!$this->logging) return parent::debug($onoff);
            $start = microtime(true);
            $name = 'debug';
            $arguments = array($onoff);
            $result = parent::debug($onoff);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
    }
} else {
    throw new \Exception('LswMemcacheBundle does not support version '.$extension->getVersion().' of the memcache extension.');
}
