<?php
namespace Lsw\MemcacheBundle\Cache;

interface MemcacheInterface {
    public function setFailureCallback($failureCallback);
    public function getServerStatus($host,$port=11211);
    public function getVersion();
    public function add($key,$var=null,$flag=0,$exptime=0);
    public function set($key,$var=null,$flag=0,$exptime=0);
    public function replace($key,$var=null,$flag=0,$exptime=0);
    public function cas($key,$var=null,$flag=0,$exptime=0,$cas=0);
    public function prepend($key,$var=null,$flag=0,$exptime=0);
    public function get($key,&$flags=null,&$cas=null);
    public function getStats($type='',$slabid=0,$limit=100);
    public function getExtendedStats($type='',$slabid=0,$limit=100);
    public function setCompressThreshold($threshold,$minSavings=0.2);
    public function delete($key,$exptime=0);
    public function increment($key,$value=1,$defval=0,$exptime=0);
    public function decrement($key,$value=1,$defval=0,$exptime=0);
    public function close();
    public function flush($delay=0);
    public function addServer($host,$tcpPort=11211,$udpPort=0,$persistent=true,$weight=1,$timeout=1,$retryInterval=15,$status=true);
    public function connect($host,$tcpPort=11211,$udpPort=0,$persistent=true,$weight=1,$timeout=1,$retryInterval=15);
    public function findServer($key);
}
