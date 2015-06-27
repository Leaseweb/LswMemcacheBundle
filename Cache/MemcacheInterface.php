<?php
namespace Lsw\MemcacheBundle\Cache;

$extension = new \ReflectionExtension('memcache');
if ($extension->getVersion()=='3.0.8') {
    interface MemcacheInterface {
        public function connect($host,$port=null,$timeout=null);
        public function pconnect($host,$port=null,$timeout=null);
        public function add_server($host,$port=null,$persistent=null,$weight=null,$timeout=null,$retry_interval=null,$status=null,$failure_callback=null);
        public function set_server_params($host,$port=null,$timeout=null,$retry_interval=null,$status=null,$failure_callback=null);
        public function set_failure_callback($failure_callback);
        public function get_server_status($host,$port=null);
        public function get_version();
        public function add($key,$var=null,$flag=null,$exptime=null);
        public function set($key,$var=null,$flag=null,$exptime=null);
        public function replace($key,$var=null,$flag=null,$exptime=null);
        public function cas($key,$var=null,$flag=null,$exptime=null,$cas=null);
        public function prepend($key,$var=null,$flag=null,$exptime=null);
        public function get($key,$flag=null,&$cas=null);
        public function get_stats($type=null,$slabid=null,$limit=null);
        public function get_extended_stats($type=null,$slabid=null,$limit=null);
        public function set_compress_threshold($threshold,$min_savings=null);
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
