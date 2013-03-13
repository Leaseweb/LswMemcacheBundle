LswMemcacheBundle
=================

If you want to optimize your web application for high load and/or low load times Memcache is an indispensable tool.
It will manage your session data without doing disk I/O on web or database servers. You can also run it as a
central object storage for your website. In this role it is used for caching expensive API calls or database queries.

This Symfony2 bundle will provide Memcache integration into Symfony2 for session and object storage. It has full
Web Debug Toolbar integration that allows you to analyze and debug the cache behavior and performance.

Screenshot: http://www.leaseweblabs.com/2013/03/memcache-support-in-symfony2-wdt/

### Installation

To install LswMemcacheBundle with Composer just add the following to your 'composer.json' file:

    {
        require: {
            "leaseweb/memcache-bundle": "dev-master",
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

Install the following dependencies (in Debian based systems using 'apt'):

    apt-get install memcached php5-memcached

Do not forget to restart you web server after adding the Memcache module. Now the Memcache
information should show up with a little double arrow (fast-forward) icon in your debug toolbar.

### Usage

When you want to use the cache from the controller you can simply call:

    $this->get('memcache')->set('someKey', 'someValue', $timeToLive);
    $this->get('memcache')->get('someKey');

The above example shows how to store value 'someValue' under key 'someKey' for a maximum of $timeToLive
seconds. In the second line the value is retrieved from Memcache. If the key can not be found or the
specified number of seconds have passed the 'get' function returns the value 'false'.

## Usage ##

Below you can see a full configuration for this bundle.

```yml
lsw_memcache:
    instances:
        default:
            persistent_id: default
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

To reference those instances in your code or in other configuration files you will have to
use the instance name:

```php
$memcache = $this->get('memcache.default');
```

### Session Support ###

This bundle also provides support for storing session data on Memcache servers. To enable session support
you will have to enable it through the ```session_support``` key. Note that the only required subkey of
the session support is ```instance``` (a valid instance). You can also specify a key prefix and an expiretime.

```yml
lsw_memcache:
    session_support:
        instance: sessions
        options:
            prefix: "session_"
            expiretime: 7200
    # instances
```

### Considerations

LswMemcacheBundle uses the 'memcached' php object (client) not the older 'memcache' php object.
For a comparison of the available clients see: http://code.google.com/p/memcached/wiki/PHPClientComparison

### Known issues

The session write that invokes a memcache set operation is executed after the page has been rendered.
The collect call of the memcache data collector is executed before the rendering of the page is complete
and therefor also before the session write is executed. This causes the session writes not to show up in
the Web Debug Toolbar.
