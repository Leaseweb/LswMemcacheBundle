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

Now the Memcache information should show up with a little double arrow (fast-forward) icon in your debug toolbar.
