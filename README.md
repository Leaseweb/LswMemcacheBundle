LswMemcacheBundle
=================

![screenshot](http://www.leaseweblabs.com/wp-content/uploads/2013/03/memcache_debug.png)

If you want to optimize your web application for high load and/or low load times Memcache is an indispensable tool.
It will manage your session data without doing disk I/O on web or database servers. You can also run it as a
central object storage for your website. In this role it is used for caching database queries using the Doctrine 
caching support or expensive API calls by implementing the caching using Memcache "get" and "set" commands.

This Symfony2 bundle will provide Memcache integration into Symfony2 and Doctrine for session storage and caching. 
It has full Web Debug Toolbar integration that allows you to analyze and debug the cache behavior and performance.

[Read the LeaseWebLabs blog about LswMemcacheBundle](http://www.leaseweblabs.com/2013/03/memcache-support-in-symfony2-wdt/)

### Requirements

- PHP 5.3.10 or higher
- php-memcached 1.0.2, 2.0.1 or 2.1.0 (this is the PHP "memcached" extension that uses "libmemcached")

NB: php-memcached 2.2.x gives runtime notices and should be avoided!

NB: Unlike the PHP "memcache" extension, the PHP "memcached" extension is not (yet) included in the PHP Windows binaries.


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
        client: default
    clients:
        default:
            hosts:
              - { dsn: localhost, port: 11211 }
```

Install the following dependencies (in Debian based systems using 'apt'):

    apt-get install memcached php5-memcached

Do not forget to restart you web server after adding the Memcache module. Now the Memcache
information should show up with a little double arrow (fast-forward) icon in your debug toolbar.

### Usage

When you want to use the cache from the controller you can simply call:

    $this->get('memcache.default')->set('someKey', 'someValue', $timeToLive);
    $this->get('memcache.default')->get('someKey');

The above example shows how to store value 'someValue' under key 'someKey' for a maximum of $timeToLive
seconds. In the second line the value is retrieved from Memcache. If the key can not be found or the
specified number of seconds have passed the 'get' function returns the value 'false'.

### Configuration

Below you can see a full configuration for this bundle.

```yml
lsw_memcache:
    clients:
        default:
            persistent_id: default  # Do NOT use this, see known issues
            hosts:
                - { dsn: 10.0.0.1, port: 11211, weight: 15 }
                - { dsn: 10.0.0.2, port: 11211, weight: 30 }
            options:
                compression: true
                serializer: json
                prefix_key: ""
                hash: default
                distribution: consistent
                libketama_compatible: true
                buffer_writes: true
                binary_protocol: true
                no_block: true
                tcp_nodelay: false
                socket_send_size: 4096
                socket_recv_size: 4096
                connect_timeout: 1000
                retry_timeout: 0
                send_timeout: 0
                recv_timeout: 0
                poll_timeout: 1000
                cache_lookups: false
                server_failure_limit: 0
        sessions:
            hosts:
                - { dsn: localhost, port: 11212 }

```

### Session Support ###

This bundle also provides support for storing session data on Memcache servers. To enable session support
you will have to enable it through the ```session``` key. Note that the only required subkey of
the session support is ```client``` (a valid client). You can also specify a key prefix and an ttl.

```yml
lsw_memcache:
    session:
        client: sessions
        prefix: "session_"
        ttl: 7200
        locking: true
        spin_lock_wait: 150000
    # clients
```

Note that the session locking is enabled by default and the default spin lock is set to poll every 150 milliseconds (150000 microseconds).

### Doctrine Support ###

This bundle also provides support for Doctrine caching on Memcache servers. To enable Doctrine caching
you will have to enable it through the ```doctrine``` key. Note that you can specify all three kinds of
Doctrine caching: 'metadata', 'result' and 'query'. The required keys within those subkeys are both 
```client``` (a valid client) and ```entity_manager``` (normally: default). You can also specify a prefix.

```yml
lsw_memcache:
    doctrine:
        metadata_cache:
            client: default
            entity_manager: default          # the name of your entity_manager connection
            document_manager: default        # the name of your document_manager connection
        result_cache:
            client: default
            entity_manager: [default, read]  # you may specify multiple entity_managers
            prefix: "result_"                # you may specify a prefix for the entries
        query_cache:
            client: default
            entity_manager: default
    # clients
```

### ADP: Anti Dog Pile

Let us examine a high traffic website case and see how Memcache behaves:

Your cache is stored for 90 minutes. It takes about 3 second to calculate the cache value and 1 ms second to read from cache the cache value. You have about 5000 requests per second and that the value is cached. You get 5000 requests per second taking about 5000 ms to read the values from cache. You might think that that is not possible since 5000 > 1000, but that depends on the number of worker processes on your web server  Let's say it is about 100 workers (under high load) with 75 threads each. Your web requests take about 20 ms each. Whenever the cache invalidates (after 90 minutes), during 3 seconds, there will be 15000 requests getting a cache miss. All the threads getting a miss will start to calculate the cache value (because they don't know the other threads are doing the same). This means that during (almost) 3 seconds the server wont answer a single request, but the requests keep coming in. Since each worker has 75 threads (holding 100 x 75 connections), the amount of workers has to go up to be able to process them.

The heavy forking will cause extra CPU usage and the each worker will use extra RAM. This unexpected increase in RAM and CPU is called the 'dog pile' effect or 'stampeding herd' and is very unwelcome during peek hours on a web service.

There is a solution: we serve the old cache entries while calculating the new value and by using an atomic read and write operation we can make sure only one thread will receive a cache miss when the content is invalidated. The algorithm is implemented in AntiDogPileMemcache class in LswMemcacheBundle. It provides the getAdp() and setAdp() functions that can be used as replacements for the normal get and set.

Please note:

- ADP might not be needed if you have low amount of hits or when calculating the new value goes relatively fast.
- ADP might not be needed if you can break up the big calculation into smaller, maybe even with different timeouts for each part.
- ADP might get you older data than the invalidation that is specified. Especially when a thread/worker gets "false" for "get" request, but fails to "set" the new calculated value afterwards.
- ADP's "getAdp" and ADP "setAdp" are more expensive than the normal "get" and "set", slowing down all cache hits.
- ADP does not guarantee that the dog pile will not occur. Restarting Memcache, flushing data or not enough RAM will also get keys evicted and you will run into the problem anyway.

### Considerations

LswMemcacheBundle uses the 'memcached' PHP extension (client) not the older 'memcache' PHP extension.
For a comparison of the available clients see: http://code.google.com/p/memcached/wiki/PHPClientComparison

### Known issues

The session write that invokes a memcache set operation is executed after the page has been rendered.
The collect call of the memcache data collector is executed before the rendering of the page is complete
and therefor also before the session write is executed. This causes the session writes not to show up in
the Web Debug Toolbar.

Enabling persistent connections (setting "persistent_id") is known to crash php5 (core dump) on some systems.
Use with caution: it is strongly recommended to leave out "persistent_id" from the configuration.

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

The "fast-forward" icon in the web debug toolbar is part of the Picas icon set (official website: http://www.picasicons.com).
The icon is licensed and may only be used to identifying the LswMemcacheBundle in the Symfony2 web debug toolbar.
All ownership and copyright of this icon remain the property of Rok Benedik.

