<?php
namespace Lsw\MemcacheBundle\Cache;

$extension = new \ReflectionExtension('memcached');
if ($extension->getVersion()<2) {

    interface MemcacheInterface
    {
        public function __construct($persistent_id);

        public function getResultCode();

        public function getResultMessage();

        public function get($key, $cache_cb = null, &$cas_token = null);

        public function getByKey($server_key, $key, $cache_cb = null, &$cas_token = null);

        public function getMulti(array $keys, &$cas_tokens = null, $flags = null);

        public function getMultiByKey($server_key, array $keys, &$cas_tokens = null, $flags = null);

        public function getDelayed(array $keys, $with_cas = null, $value_cb = null);

        public function getDelayedByKey($server_key, array $keys, $with_cas = null, $value_cb = null);

        public function fetch();

        public function fetchAll();

        public function set($key, $value, $expiration = null);

        public function setByKey($server_key, $key, $value, $expiration = null);

        public function setMulti(array $items, $expiration = null);

        public function setMultiByKey($server_key, array $items, $expiration = null);

        public function cas($cas_token, $key, $value, $expiration = null);

        public function casByKey($cas_token, $server_key, $key, $value, $expiration = null);

        public function add($key, $value, $expiration = null);

        public function addByKey($server_key, $key, $value, $expiration = null);

        public function append($key, $value, $expiration = null);

        public function appendByKey($server_key, $key, $value, $expiration = null);

        public function prepend($key, $value, $expiration = null);

        public function prependByKey($server_key, $key, $value, $expiration = null);

        public function replace($key, $value, $expiration = null);

        public function replaceByKey($server_key, $key, $value, $expiration = null);

        public function delete($key, $time = null);

        public function deleteByKey($server_key, $key, $time = null);

        public function increment($key, $offset = null);

        public function decrement($key, $offset = null);

        public function addServer($host, $port, $weight = null);

        public function addServers(array $servers);

        public function getServerList();

        public function getServerByKey($server_key);

        public function getStats();

        public function getVersion();

        public function flush($delay = null);

        public function getOption($option);

        public function setOption($option, $value);
    }

} else {

    interface MemcacheInterface
    {
        public function __construct($persistent_id);

        public function getResultCode();

        public function getResultMessage();

        public function get($key, $cache_cb = null, &$cas_token = null);

        public function getByKey($server_key, $key, $cache_cb = null, &$cas_token = null);

        public function getMulti(array $keys, &$cas_tokens = null, $flags = null);

        public function getMultiByKey($server_key, array $keys, &$cas_tokens = null, $flags = null);

        public function getDelayed(array $keys, $with_cas = null, $value_cb = null);

        public function getDelayedByKey($server_key, array $keys, $with_cas = null, $value_cb = null);

        public function fetch();

        public function fetchAll();

        public function set($key, $value, $expiration = null);

        public function setByKey($server_key, $key, $value, $expiration = null);

        public function touch($key, $expiration);

        public function touchByKey($server_key, $key, $expiration);

        public function setMulti(array $items, $expiration = null);

        public function setMultiByKey($server_key, array $items, $expiration = null);

        public function cas($cas_token, $key, $value, $expiration = null);

        public function casByKey($cas_token, $server_key, $key, $value, $expiration = null);

        public function add($key, $value, $expiration = null);

        public function addByKey($server_key, $key, $value, $expiration = null);

        public function append($key, $value, $expiration = null);

        public function appendByKey($server_key, $key, $value, $expiration = null);

        public function prepend($key, $value, $expiration = null);

        public function prependByKey($server_key, $key, $value, $expiration = null);

        public function replace($key, $value, $expiration = null);

        public function replaceByKey($server_key, $key, $value, $expiration = null);

        public function delete($key, $time = null);

        public function deleteMulti($keys, $time = null);

        public function deleteByKey($server_key, $key, $time = null);

        public function deleteMultiByKey($server_key, $keys, $time = null);

        public function increment($key, $offset = null, $initial_value = null, $expiry = null);

        public function decrement($key, $offset = null, $initial_value = null, $expiry = null);

        public function incrementByKey($server_key, $key, $offset = null, $initial_value = null, $expiry = null);

        public function decrementByKey($server_key, $key, $offset = null, $initial_value = null, $expiry = null);

        public function addServer($host, $port, $weight = null);

        public function addServers(array $servers);

        public function getServerList();

        public function getServerByKey($server_key);

        public function resetServerList();

        public function quit();

        public function getStats();

        public function getVersion();

        public function getAllKeys();

        public function flush($delay = null);

        public function getOption($option);

        public function setOption($option, $value);

        public function setOptions($options);

        public function isPersistent();

        public function isPristine();
    }
}