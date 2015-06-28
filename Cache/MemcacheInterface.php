<?php
namespace Lsw\MemcacheBundle\Cache;

$extension = new \ReflectionExtension('memcache');
if ($extension->getVersion()=='3.0.8') {
    interface MemcacheInterface {
        public function connect($host,$port=null,$timeout=null);
        public function pconnect($host,$port=null,$timeout=null);
        public function addServer($host,$port=null,$persistent=null,$weight=null,$timeout=null,$retryInterval=null,$status=null,$failureCallback=null);
        public function setServerParams($host,$port=null,$timeout=null,$retryInterval=null,$status=null,$failureCallback=null);
        public function setFailureCallback($failureCallback);
        public function getServerStatus($host,$port=null);
        public function getVersion();
        public function add($key,$var=null,$flag=null,$exptime=null);
        public function set($key,$var=null,$flag=null,$exptime=null);
        public function replace($key,$var=null,$flag=null,$exptime=null);
        public function cas($key,$var=null,$flag=null,$exptime=null,$cas=null);
        public function prepend($key,$var=null,$flag=null,$exptime=null);
        public function get($key,&$flags=null,&$cas=null);
        public function getStats($type=null,$slabid=null,$limit=null);
        public function getExtendedStats($type=null,$slabid=null,$limit=null);
        public function setCompressThreshold($threshold,$minSavings=null);
        public function delete($key,$exptime=null);
        public function increment($key,$value=null,$defval=null,$exptime=null);
        public function decrement($key,$value=null,$defval=null,$exptime=null);
        public function close();
        public function flush($delay=null);
        public function debug($onoff);
    }
} else {
    throw new \Exception('LswMemcacheBundle does not support version '.$extension->getVersion().' of the memcache extension.');
}
