LswMemcacheBundle
=================

Symfony2 bundle for Memcache Session management with Web Debug Toolbar integration.

Add the following 'handler_id' to your 'app/config/config.yml' file under session:

    framework:
        ...
        session:
            handler_id:  memcache.session_handler

Install the following dependencies (in Debian based systems using 'apt'):

    apt-get install memcached php5-memcache
    

TODO
----

- Documentation in this readme
- Add to packagist
- Write blog post
- Screenshot for blog
