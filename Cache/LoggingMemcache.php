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
        public function addServer($host,$port=null,$persistent=null,$weight=null,$timeout=null,$retryInterval=null,$status=null,$failureCallback=null) {
            if (!$this->logging) return parent::addServer($host,$port,$persistent,$weight,$timeout,$retryInterval,$status,$failureCallback);
            $start = microtime(true);
            $name = 'addServer';
            $arguments = array($host,$port,$persistent,$weight,$timeout,$retryInterval,$status,$failureCallback);
            $result = parent::addServer($host,$port,$persistent,$weight,$timeout,$retryInterval,$status,$failureCallback);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setServerParams($host,$port=null,$timeout=null,$retryInterval=null,$status=null,$failureCallback=null) {
            if (!$this->logging) return parent::setServerParams($host,$port,$timeout,$retryInterval,$status,$failureCallback);
            $start = microtime(true);
            $name = 'setServerParams';
            $arguments = array($host,$port,$timeout,$retryInterval,$status,$failureCallback);
            $result = parent::setServerParams($host,$port,$timeout,$retryInterval,$status,$failureCallback);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setFailureCallback($failureCallback) {
            if (!$this->logging) return parent::setFailureCallback($failureCallback);
            $start = microtime(true);
            $name = 'setFailureCallback';
            $arguments = array($failureCallback);
            $result = parent::setFailureCallback($failureCallback);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getServerStatus($host,$port=null) {
            if (!$this->logging) return parent::getServerStatus($host,$port);
            $start = microtime(true);
            $name = 'getServerStatus';
            $arguments = array($host,$port);
            $result = parent::getServerStatus($host,$port);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getVersion() {
            if (!$this->logging) return parent::getVersion();
            $start = microtime(true);
            $name = 'getVersion';
            $arguments = array();
            $result = parent::getVersion();
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
        public function getStats($type=null,$slabid=null,$limit=null) {
            if (!$this->logging) return parent::getStats($type,$slabid,$limit);
            $start = microtime(true);
            $name = 'getStats';
            $arguments = array($type,$slabid,$limit);
            $result = parent::getStats($type,$slabid,$limit);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function getExtendedStats($type=null,$slabid=null,$limit=null) {
            if (!$this->logging) return parent::getExtendedStats($type,$slabid,$limit);
            $start = microtime(true);
            $name = 'getExtendedStats';
            $arguments = array($type,$slabid,$limit);
            $result = parent::getExtendedStats($type,$slabid,$limit);
            $time = microtime(true) - $start;
            $this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return $result;
        }
        public function setCompressThreshold($threshold,$minSavings=null) {
            if (!$this->logging) return parent::setCompressThreshold($threshold,$minSavings);
            $start = microtime(true);
            $name = 'setCompressThreshold';
            $arguments = array($threshold,$minSavings);
            $result = parent::setCompressThreshold($threshold,$minSavings);
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
