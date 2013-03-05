LswMemcacheBundle
=================

Symfony2 bundle for Memcache session management with Web Debug Toolbar integration.

### Installation

To install LswMemcacheBundle with Composer just add the following to your 'composer.json' file:

    {
        require: {
            "leaseweb/memcache-bundle": "dev-master"
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

Add the following 'handler_id' to your 'app/config/config.yml' file under session:

    framework:
        ...
        session:
            handler_id:  memcache.session_handler

Install the following dependencies (in Debian based systems using 'apt'):

    apt-get install memcached php5-memcache

Do not forget to restart you web server after adding the Memcache module. Now the Memcache
information should show up with a little double arrow (fast-forward) icon in your debug toolbar.

### Usage

When you want to use the cache from the controller you can simply call:
  
    $this->get('memcache')->set('someKey', 'someValue', $timeToLive);
    $this->get('memcache')->get('someKey');
    
The above example shows how to store value 'someValue' under key 'someKey' for a maximum of $timeToLive
seconds. In the second line the value is retrieved from Memcache. If the key can not be found or the
specified number of seconds have passed the 'get' function returns the value 'false'.

### Configuration

If you want to configure the bundle you can override the following parameters in your config:

    parameters:
        memcache_host: 127.0.0.1
        memcache_port: 11211
        memcache_session_prefix: "session_"
        memcache_session_expire: 3600
        
These settings specify on which host and port the Memcache daemon runs, what prefix should be used for
session data and how long it should store the session data.
