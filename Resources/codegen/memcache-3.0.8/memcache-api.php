<?php

/**
 * Collator class.
 */

class MemcachePool {
	
	public function __construct() {}
	
	//proto object memcache_connect(string host [, int port [, double timeout ] ])
	
	//public function connect($host,$port=11211,$timeout=1) {}
	
	//proto object memcache_pconnect(string host [, int port [, double timeout ] ])
	
	//public function pconnect($host,$port=11211,$timeout=1) {}
	
	//proto bool memcache_add_server(string host [, int port [, bool persistent [, int weight [, double timeout [, int retry_interval [, bool status [, callback failure_callback ] ] ] ] ] ] ])
	
	//public function addServer($host,$port=11211,$persistent=true,$weight=1,$timeout=1,$retryInterval=15,$status=true,$failureCallback=null) {}
		
	//proto bool memcache_set_server_params( string host [, int port [, double timeout [, int retry_interval [, bool status [, callback failure_callback ] ] ] ] ])
	
	//public function setServerParams($host,$port=11211,$timeout=1,$retryInterval=15,$status=true,$failureCallback=null) {}
	
	//proto bool memcache_set_failure_callback( callback failure_callback )
	
	public function setFailureCallback($failureCallback) {}
	
	//proto int memcache_get_server_status( string host [, int port ])
	
	public function getServerStatus($host,$port=11211) {}
	
	//proto string memcache_get_version( object memcache )
	
	public function getVersion() {}
	
	// proto bool memcache_add(object memcache, mixed key [, mixed var [, int flag [, int exptime ] ] ])
	
	public function add($key,$var=null,$flag=0,$exptime=0) {}
	
	//proto bool memcache_set(object memcache, mixed key [, mixed var [, int flag [, int exptime ] ] ])
	
	public function set($key,$var=null,$flag=0,$exptime=0) {}
	
	//proto bool memcache_replace(object memcache, mixed key [, mixed var [, int flag [, int exptime ] ] )
	
	public function replace($key,$var=null,$flag=0,$exptime=0) {}
	
	// proto bool memcache_cas(object memcache, mixed key [, mixed var [, int flag [, int exptime [, long cas ] ] ] ])
	
	public function cas($key,$var=null,$flag=0,$exptime=0,$cas=0) {}
	
	//proto bool memcache_prepend(object memcache, mixed key [, mixed var [, int flag [, int exptime ] ] ])
	
	public function prepend($key,$var=null,$flag=0,$exptime=0) {}
	
	//proto mixed memcache_get( object memcache, mixed key [, mixed &flags [, mixed &cas ] ] )
	
	public function get($key,&$flags=null,&$cas=null) {}
	
	//proto array memcache_get_stats( object memcache [, string type [, int slabid [, int limit ] ] ])
	
	public function getStats($type='',$slabid=0,$limit=100) {}
	
	//proto array memcache_get_extended_stats( object memcache [, string type [, int slabid [, int limit ] ] ])
	
	public function getExtendedStats($type='',$slabid=0,$limit=100) {}
	
	//proto array memcache_set_compress_threshold( object memcache, int threshold [, float min_savings ] )
	
	public function setCompressThreshold($threshold,$minSavings=0.2) {}
	
	//proto bool memcache_delete(object memcache, mixed key [, int exptime ])
	
	public function delete($key,$exptime=0) {}
	
	//proto mixed memcache_increment(object memcache, mixed key [, int value [, int defval [, int exptime ] ] ])
	
	public function increment($key,$value=1,$defval=0,$exptime=0) {}
	
	//proto mixed memcache_decrement(object memcache, mixed key [, int value [, int defval [, int exptime ] ] ])
	
	public function decrement($key,$value=1,$defval=0,$exptime=0) {}
	
	//proto bool memcache_close( object memcache )
	
	public function close() {}
	
	//proto bool memcache_flush( object memcache [, int delay ] )
	
	public function flush($delay=0) {}
	
	//proto bool memcache_debug( bool onoff )
	
	//public function debug($onoff) {}
	
	//proto bool MemcachePool::addServer(string host [, int tcp_port [, int udp_port [, bool persistent [, int weight [, double timeout [, int retry_interval [, bool status] ] ] ] ])
	
	public function addServer($host,$tcpPort=11211,$udpPort=0,$persistent=true,$weight=1,$timeout=1,$retryInterval=15,$status=true) {}
	
	//proto bool MemcachePool::connect(string host [, int tcp_port [, int udp_port [, bool persistent [, int weight [, double timeout [, int retry_interval] ] ] ] ] ])
	
	public function connect($host,$tcpPort=11211,$udpPort=0,$persistent=true,$weight=1,$timeout=1,$retryInterval=15) {}
	
	//proto string MemcachePool::findServer(string key)
	
	public function findServer($key) {}
	
}
