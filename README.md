[![Build Status](https://travis-ci.org/LeaseWeb/LswMemcacheBundle.svg)](https://travis-ci.org/LeaseWeb/LswMemcacheBundle)
[![Average time to resolve an issue](http://isitmaintained.com/badge/resolution/LeaseWeb/LswMemcacheBundle.svg)](http://isitmaintained.com/project/LeaseWeb/LswMemcacheBundle "Average time to resolve an issue")
[![Percentage of issues still open](http://isitmaintained.com/badge/open/LeaseWeb/LswMemcacheBundle.svg)](http://isitmaintained.com/project/LeaseWeb/LswMemcacheBundle "Percentage of issues still open")
[![Total Downloads](https://img.shields.io/packagist/dt/leaseweb/memcache-bundle.svg?style=flat-square)](https://packagist.org/packages/leaseweb/memcache-bundle)

LswMemcacheBundle
=================

![screenshot](http://www.leaseweblabs.com/wp-content/uploads/2015/06/memcache_v2.png)

If you want to optimize your web application for high load and/or low load times Memcache is an indispensable tool.
It will manage your session data without doing disk I/O on web or database servers. You can also run it as a
central object storage for your website. In this role it is used for caching database queries using the Doctrine 
caching support or expensive API calls by implementing the caching using Memcache "get" and "set" commands.

This Symfony bundle will provide Memcache integration into Symfony and Doctrine for session storage and caching. 
It has full Web Debug Toolbar integration that allows you to analyze and debug the cache behavior and performance.

[Read the LeaseWebLabs blog about LswMemcacheBundle](http://www.leaseweblabs.com/2015/06/version-2-of-our-memcache-bundle-for-symfony-is-released/)

### Requirements

- PHP 5.3.10 or higher
- php-memcache 3.0.6 or higher
- memcached 1.4 or higher  

NB: This bundle no longer uses the PHP "memcached" extension that uses "libmemcached", see "Considerations". 

PHP7 support is currently (experimentally) available by compiling and installing: https://github.com/websupport-sk/pecl-memcache/tree/php7

### Installation

To install LswMemcacheBundle with Composer just add the following to your 'composer.json' file:

    {
        require: {
            "leaseweb/memcache-bundle": "*",
            ...
        }
    }

The next thing you should do is install the bundle by executing the following command:

    php composer.phar update leaseweb/memcache-bundle

Finally, add the bundle to the registerBundles function of the AppKernel class in the 'app/AppKernel.php' file:

    public function registerBundles()
    {
        $bundles = array(
            ...
            new Lsw\MemcacheBundle\LswMemcacheBundle(),
            ...
        );

Configure the bundle by adding the following to app/config/config.yml':

```yml
lsw_memcache:
    session:
        pool: default
    pools:
        default:
            servers:
              - { host: localhost, tcp_port: 11211 }
```

Install the following dependencies (in Debian based systems using 'apt'):

    apt-get install memcached php5-memcache

Do not forget to restart you web server after adding the Memcache module. Now the Memcache
information should show up with a little double arrow (fast-forward) icon in your debug toolbar.

### Usage

When you want to use the cache from the controller you can simply call:

    $this->get('memcache.default')->set('someKey', 'someValue', 0, $timeToLive);
    $this->get('memcache.default')->get('someKey');

The above example shows how to store value 'someValue' under key 'someKey' for a maximum of $timeToLive
seconds (the 0 parameter are the 'flags'). In the second line the value is retrieved from Memcache.
If the key can not be found or the specified number of seconds have passed the 'get' function returns
the value 'false'.

### Configuration

Below you can see an example configuration for this bundle.

```yml
lsw_memcache:
    pools:
        default:
            servers:
                - { host: 10.0.0.1, tcp_port: 11211, weight: 15 }
                - { host: 10.0.0.2, tcp_port: 11211, weight: 30 }
            options:
		        allow_failover: true
		        max_failover_attempts: 20
		        default_port: 11211
		        chunk_size: 32768
		        protocol: ascii
		        hash_strategy: consistent
		        hash_function: crc32
		        redundancy: true
		        session_redundancy: 2
		        compress_threshold: 20000
		        lock_timeout: 15
        sessions:
            servers:
                - { host: localhost, tcp_port: 11212 }

```

### Session Support ###

This bundle also provides support for storing session data on Memcache servers. To enable session support
you will have to enable it through the ```session``` key (```auto_load``` is true by default). Note that the only
required subkey of the session support is ```pool``` (a valid pool). You can also specify a key ```prefix```
and a ```ttl```.

```yml
lsw_memcache:
    session:
        pool: sessions
        auto_load: true
        prefix: "session_"
        ttl: 7200
        locking: true
        spin_lock_wait: 150000
    # pools
```

Note that the session locking is enabled by default and the default spin lock is set to poll every 150 milliseconds (150000 microseconds).

### Doctrine Support ###

This bundle also provides support for Doctrine caching on Memcache servers. To enable Doctrine caching
you will have to enable it through the ```doctrine``` key. Note that you can specify all three kinds of
Doctrine caching: 'metadata', 'result' and 'query'. The required keys within those subkeys are both 
```pool``` (a valid pool) and ```entity_manager``` (normally: default). You can also specify a ```prefix```.

```yml
lsw_memcache:
    doctrine:
        metadata_cache:
            pool: default
            entity_manager: default          # the name of your entity_manager connection
            document_manager: default        # the name of your document_manager connection
        result_cache:
            pool: default
            entity_manager: [default, read]  # you may specify multiple entity_managers
            prefix: "result_"                # you may specify a prefix for the entries
        query_cache:
            pool: default
            entity_manager: default
    # pools
```

### Firewall Support ###

This bundle also provides support a firewall that limits the number of concurrent requests per IP address.
It maintains a counter of running requests per IP address and delays (throttles) the requests if nessecary. 
To enable firewall support you will have to enable it through the ```firewall``` key. Note that the only
required subkey of the firewall support is ```pool``` (a valid pool). You can also specify a key ```prefix```
and a ```concurrency``` (default is 10). If you use one or more reverse proxies, then specify them in the
```reverse_proxies``` key.

```yml
lsw_memcache:
    firewall:
        pool: firewall
        prefix: "firewall_"
        concurrency: 10
        reverse_proxies: [10.0.0.1]
    # pools
```

### ADP: Anti Dog Pile

Let us examine a high traffic website case and see how Memcache behaves:

Your cache is stored for 90 minutes. It takes about 3 second to calculate the cache value and 1 ms second to read the cached value from the cache. You have about 5000 requests per second and let's assume that the value is cached. You get 5000 requests per second taking about 5000 ms to read the values from cache. You might think that that is not possible since 5000 > 1000, but that depends on the number of worker processes on your web server. Let's say it is about 100 workers (under high load) with 75 threads each. Your web requests take about 20 ms each. Whenever the cache invalidates (after 90 minutes), during 3 seconds, there will be 15000 requests getting a cache miss. All the threads getting a miss will start to calculate the cache value (because they don't know the other threads are doing the same). This means that during (almost) 3 seconds the server wont answer a single request, but the requests keep coming in. Since each worker has 75 threads (holding 100 x 75 connections), the amount of workers has to go up to be able to process them.

The heavy forking will cause extra CPU usage and the each worker will use extra RAM. This unexpected increase in RAM and CPU is called the 'dog pile' effect or 'stampeding herd' or 'thundering herd' and is very unwelcome during peak hours on a web service.

There is a solution: we serve the old cache entries while calculating the new value and by using an atomic read and write operation we can make sure only one thread will receive a cache miss when the content is invalidated. The algorithm is implemented in AntiDogPileMemcache class in LswMemcacheBundle. It provides the getAdp(), setAdp() and deleteAdp() functions that can be used as replacements for the normal get, set and delete.

Please note:

- ADP might not be needed if you have low amount of hits or when calculating the new value goes relatively fast.
- ADP might not be needed if you can break up the big calculation into smaller, maybe even with different timeouts for each part.
- ADP might get you older data than the invalidation that is specified. Especially when a thread/worker gets "false" for "get" request, but fails to "set" the new calculated value afterwards.
- ADP's "getAdp", "setAdp" and "deleteAdp" are more expensive than the normal "get", "set" and "delete", slowing down all cache hits.
- ADP does not guarantee that the dog pile will not occur. Restarting Memcache, flushing data or not enough RAM will also get keys evicted and you will run into the problem anyway.

### Considerations

LswMemcacheBundle uses the 'memcache' PHP extension (memcached client) and not the libmemcache based 'memcached' PHP extension.

Major version 1 of this bundle used the other extension. In major version 2 of this bundle the full featured version 3.0.8 of PECL "memcache" (without the 'd') was chosen, due to it's complete feature set and good design and support.

### Known issues

The session write that invokes a memcache set operation is executed after the page has been rendered.
The collect call of the memcache data collector is executed before the rendering of the page is complete
and therefor also before the session write is executed. This causes the session writes not to show up in
the Web Debug Toolbar.

### Credits

Doctrine support is based on the implementation in SncRedisBundle:

https://github.com/snc/SncRedisBundle by Henrik Westphal

- DependencyInjection/LswMemcacheExtension.php
- DependencyInjection/Configuration.php
- DependencyInjection/Compiler/EnableSessionSupport.php

Are based on implementation in:

https://github.com/Emagister/MemcachedBundle by Christian Soronellas

- Command/StatisticsCommand.php

Is based on an implementation in:

https://github.com/beryllium/CacheBundle by Kevin Boyd

### License

This bundle is under the MIT license.
