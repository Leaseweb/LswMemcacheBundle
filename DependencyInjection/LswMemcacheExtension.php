<?php

namespace Lsw\MemcacheBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Applies the configuration for the Memcache object
 * Based on Emagister\MemcachedBundle by Christian Soronellas
 */
class LswMemcacheExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('config.yml');
        if ($container->getParameter('kernel.debug')) {
            $loader->load('debug.yml');
        }

        if (isset($config['session'])) {
            $this->enableSessionSupport($config, $container);
        } else {
        	$container->setParameter('memcache.session_handler.auto_load',false);
        }
        if (isset($config['doctrine'])) {
          $this->loadDoctrine($config, $container);
        }
        if (isset($config['firewall'])) {
        	$this->loadFirewall($config, $container);
        }
        if (isset($config['pools'])) {
            $this->addClients($config['pools'], $container);
        }
    }

    /**
     * Enables session support using Memcache based on the configuration
     *
     * @param string           $config    Configuration for bundle
     * @param ContainerBuilder $container Service container
     *
     * @return void
     */
    private function enableSessionSupport($config, ContainerBuilder $container)
    {
        // make sure the pool is specified and it exists
        $pool = $config['session']['pool'];
        if (null === $pool) {
            return;
        }
        if (!isset($config['pools']) || !isset($config['pools'][$pool])) {
            throw new \LogicException(sprintf('The pool "%s" does not exist! Cannot enable the session support!', $pool));
        }
        // calculate options
        $sessionOptions = $container->getParameter('session.storage.options');
        $options = array();
        if (isset($config['session']['ttl'])) {
            $options['expiretime'] = $config['session']['ttl'];
        } elseif (isset($sessionOptions['cookie_lifetime'])) {
            $options['expiretime'] = $sessionOptions['cookie_lifetime'];
        }
        $options['prefix'] = $config['session']['prefix'];
        $options['locking'] = $config['session']['locking'];
        $options['spin_lock_wait'] = $config['session']['spin_lock_wait'];
        $options['lock_max_wait'] = $config['session']['lock_max_wait'];
        // set the auto_load parameter
        $container->setParameter('memcache.session_handler.auto_load', $config['session']['auto_load']);
        // load the session handler
        $definition = new Definition($container->getParameter('memcache.session_handler.class'));
        $container->setDefinition('memcache.session_handler', $definition);
        $definition
            ->addArgument(new Reference(sprintf('memcache.%s', $pool)))
            ->addArgument($options);
       	$this->addClassesToCompile(array($definition->getClass()));
    }

    /**
     * Loads the Doctrine configuration.
     *
     * @param array $config A configuration array
     * @param ContainerBuilder $container A ContainerBuilder instance
     */
    protected function loadDoctrine(array $config, ContainerBuilder $container)
    {
        foreach ($config['doctrine'] as $name => $cache) {
            $pool = new Reference(sprintf('memcache.%s', $cache['pool']));
            foreach ($cache['entity_managers'] as $em) {
                $def = new Definition($container->getParameter('memcache.doctrine_cache.class'));
                if (method_exists($def, 'setShared')) { // Symfony 2.8+
                    $def->setShared(true);
                } else { // For Symfony <2.8 compatibility
                    $def->setScope(ContainerInterface::SCOPE_CONTAINER);
                }
                $def->addMethodCall('setMemcache', array($pool));
                if ($cache['prefix']) {
                    $def->addMethodCall('setPrefix', array($cache['prefix']));
                }
                $container->setDefinition(sprintf('doctrine.orm.%s_%s', $em, $name), $def);
            }
            foreach ($cache['document_managers'] as $dm) {
                $def = new Definition($container->getParameter('memcache.doctrine_cache.class'));
                if (method_exists($def, 'setShared')) { // Symfony 2.8+
                    $def->setShared(true);
                } else { // For Symfony <2.8 compatibility
                    $def->setScope(ContainerInterface::SCOPE_CONTAINER);
                }
                $def->addMethodCall('setMemcache', array($pool));
                if ($cache['prefix']) {
                    $def->addMethodCall('setPrefix', array($cache['prefix']));
                }
                $container->setDefinition(sprintf('doctrine.odm.mongodb.%s_%s', $dm, $name), $def);
            }
        }
    }
    
    /**
     * Loads the Firewall configuration.
     *
     * @param array $config A configuration array
     * @param ContainerBuilder $container A ContainerBuilder instance
     */
    protected function loadFirewall(array $config, ContainerBuilder $container)
    {
    	// make sure the pool is specified and it exists
    	$pool = $config['firewall']['pool'];
    	if (null === $pool) {
    		return;
    	}
    	if (!isset($config['pools']) || !isset($config['pools'][$pool])) {
    		throw new \LogicException(sprintf('The pool "%s" does not exist! Cannot enable the firewall!', $pool));
    	}
    	// calculate options
    	$options = array();
    	$options['prefix'] = $config['firewall']['prefix'];
    	$options['concurrency']    = $config['firewall']['concurrency'];
    	$options['spin_lock_wait'] = $config['firewall']['spin_lock_wait'];
    	$options['lock_max_wait']  = $config['firewall']['lock_max_wait'];
    	$options['reverse_proxies']  = $config['firewall']['reverse_proxies'];
    	$options['x_forwarded_for']  = $config['firewall']['x_forwarded_for'];
    	// load the firewall handler
    	$definition = new Definition($container->getParameter('memcache.firewall_handler.class'));
    	$container->setDefinition('memcache.firewall_handler', $definition);
    	$definition
    	    ->addArgument(new Reference(sprintf('memcache.%s', $pool)))
    	    ->addArgument($options);
    	$definition->addTag('kernel.event_listener', array('event'=>'kernel.request','method'=>'onKernelRequest'));
    	$definition->addTag('kernel.event_listener', array('event'=>'kernel.terminate','method'=>'onKernelTerminate'));
    	$this->addClassesToCompile(array($definition->getClass()));
    }

    /**
     * Adds memcache/memcache pools to the service contaienr
     *
     * @param array            $pools   Array of pool configurations
     * @param ContainerBuilder $container Service container
     *
     * @throws \LogicException
     */
    private function addClients(array $pools, ContainerBuilder $container)
    {
        foreach ($pools as $pool => $memcacheConfig) {
            $this->newMemcacheClient($pool, $memcacheConfig, $container);
        }
    }

    /**
     * Creates a new Memcache definition
     *
     * @param string           $name      Client name
     * @param array            $config    Client configuration
     * @param ContainerBuilder $container Service container
     *
     * @throws \LogicException
     */
    private function newMemcacheClient($name, array $config, ContainerBuilder $container)
    {
        // Check if the Memcache extension is loaded
        if (!extension_loaded('memcache')) {
            throw new \LogicException('Memcache extension is not loaded! To configure pools it MUST be loaded!');
        }

        $memcache = new Definition('Lsw\MemcacheBundle\Cache\AntiDogPileMemcache');
        $memcache->addArgument(new Parameter('kernel.debug'));

        // Add servers to the memcache pool
        foreach ($config['servers'] as $s) {
            $server = array(
                $s['host'],
                $s['tcp_port'],
                $s['udp_port'],
                $s['persistent'],
                $s['weight'],
                $s['timeout'],
                $s['retry_interval']
            );
            if ($s['host']) {
                $memcache->addMethodCall('addServer', $server);
            }
        }
        
        $memcache->addArgument($config['options']);

        $options = array();
        // Make sure that config values are human readable
        foreach ($config['options'] as $key => $value) {
            $options[$key] = var_export($value, true);
        }

        // Add the service to the container
        $serviceName = sprintf('memcache.%s', $name);
        $container->setDefinition($serviceName, $memcache);
        // Add the service to the data collector
        if ($container->hasDefinition('memcache.data_collector')) {
            $definition = $container->getDefinition('memcache.data_collector');
            $definition->addMethodCall('addClient', array($name, $options, new Reference($serviceName)));
        }
    }

}
