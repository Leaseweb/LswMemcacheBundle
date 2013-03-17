<?php

namespace Lsw\MemcacheBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Applies the configuration for the Memcached object
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
        $loader->load('services.yml');

        if (isset($config['session'])) {
            $this->enableSessionSupport($config, $container);
        }
        if (isset($config['clients'])) {
            $this->addClients($config['clients'], $container);
        }
    }

    /**
     * Given a handler (memcache/memcached) enables session support
     *
     * @param string           $config    Configuration for bundle
     * @param ContainerBuilder $container Service container
     *
     * @return void
     */
    private function enableSessionSupport($config, ContainerBuilder $container)
    {
        // make sure the client is specified and it exists
        $client = $config['session']['client'];
        if (null === $client) {
            return;
        }
        if (!isset($config['clients']) || !isset($config['clients'][$client])) {
            throw new \LogicException(sprintf('The client "%s" does not exist! Cannot enable the session support!', $client));
        }
        // calculate options
        $sessionOptions = $container->getParameter('session.storage.options');
        $options = array();
        if (isset($config['session']['ttl'])) {
            $options['ttl'] = $config['session']['ttl'];
        } elseif (isset($sessionOptions['cookie_lifetime'])) {
            $options['ttl'] = $sessionOptions['cookie_lifetime'];
        }
        if (isset($config['session']['prefix'])) {
            $options['prefix'] = $config['session']['prefix'];
        }
        // load the session handler
        $definition = new Definition($container->getParameter('memcache.session_handler.class'));
        $container->setDefinition('memcache.session_handler', $definition);
        $definition
            ->addArgument(new Reference(sprintf('memcache.%s', $client)))
            ->addArgument($options);
        $this->addClassesToCompile(array($definition->getClass()));
    }

    /**
     * Adds memcache/memcached clients to the service contaienr
     *
     * @param array            $clients   Array of client configurations
     * @param ContainerBuilder $container Service container
     *
     * @throws \LogicException
     */
    private function addClients(array $clients, ContainerBuilder $container)
    {
        foreach ($clients as $client => $memcachedConfig) {
            $this->newMemcachedClient($client, $memcachedConfig, $container);
        }
    }

    /**
     * Creates a new Memcached definition
     *
     * @param string           $name      Client name
     * @param array            $config    Client configuration
     * @param ContainerBuilder $container Service container
     *
     * @throws \LogicException
     */
    private function newMemcachedClient($name, array $config, ContainerBuilder $container)
    {
        // Check if the Memcached extension is loaded
        if (!extension_loaded('memcached')) {
            throw LogicException('Memcached extension is not loaded! To configure memcached clients it MUST be loaded!');
        }

        $memcached = new Definition('Lsw\MemcacheBundle\Cache\LoggingMemcache');
        $debug = new Parameter('kernel.debug');
        $memcached->addArgument($debug);

        // Check if it has to be persistent
        if (isset($config['persistent_id'])) {
            $memcached->addArgument($config['persistent_id']);
        }

        // Add servers to the memcached client
        $servers = array();
        foreach ($config['hosts'] as $host) {
            $servers[] = array(
                $host['dsn'],
                $host['port'],
                $host['weight']
            );
        }
        $memcached->addMethodCall('addServers', array($servers));

        // Get default memcached options
        $options = $container->getParameter('memcache.default_options');

        // Add overriden options
        if (isset($config['options'])) {
            foreach ($options as $key => $value) {
                if (isset($config['options'][$key])) {
                    $type = gettype($value);
                    if ($key == 'serializer') {
                        // serializer option needs to be supported and is a constant
                        if ($value != 'php' && !constant('Memcached::HAVE_' . strtoupper($value))) {
                            throw new \LogicException("Invalid serializer specified for Memcached: $value");
                        }
                        $value = constant('Memcached::SERIALIZER_' . strtoupper($value));
                    } elseif ($key == 'distribution') {
                        // distribution is defined as a constant
                        $value = constant('Memcached::DISTRIBUTION_' . strtoupper($value));
                    } else {
                        $value = $config['options'][$key];
                    }
                    if ($type!='null') {
                        settype($value, $type);
                        $constant = 'Memcached::OPT_'.strtoupper($key);
                        $memcached->addMethodCall('setOption', array(constant($constant), $value));
                    }

                }
            }
        }

        // Make sure that config values are human readable
        foreach ($options as $key => $value) {
            $options[$key] = var_export($value, true);
        }

        // Add the service to the container
        $serviceName = sprintf('memcache.%s', $name);
        $container->setDefinition($serviceName, $memcached);
        // Add the service to the data collector
        if ($debug) {
            $definition = $container->getDefinition('memcache.data_collector');
            $definition->addMethodCall('addClient', array($name, $options, new Reference($serviceName)));
        }
    }

}