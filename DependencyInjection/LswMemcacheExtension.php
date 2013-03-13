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

        if (isset($config['session_support']) && null !== $config['session_support']['instance']) {
            if (!isset($config['instances']) || !isset($config['instances'][$config['session_support']['instance']])) {
                throw new \LogicException(sprintf('The instance "%s" does not exist! Cannot enable the session support!', $config['session_support']['instance']));
            }
            $options = $config['session_support']['options'];
            $this->enableSessionSupport($config['session_support']['instance'], $options, $container);
        }
        if (isset($config['instances'])) {
            $this->addInstances($config['instances'], $container);
        }
    }

        /**
     * Given a handler (memcache/memcached) enables session support
     *
     * @param string $type
     * @param string $instanceId
     * @param array $options
     * @param ContainerBuilder $container
     */
    private function enableSessionSupport($instanceId, array $options, ContainerBuilder $container)
    {
        $definition = $container->findDefinition('memcache.session_handler');
        $definition
            ->addArgument(new Reference(sprintf('memcache.%s', $instanceId)))
            ->addArgument($options)
        ;

        $this->addClassesToCompile(array(
            $definition->getClass()
        ));
    }

    /**
     * Adds memcache/memcached instances to the service contaienr
     *
     * @param array $instances
     * @param ContainerBuilder $container
     *
     * @throws \LogicException
     */
    private function addInstances(array $instances, ContainerBuilder $container)
    {
        foreach ($instances as $instance => $memcachedConfig) {
            $this->newMemcachedInstance($instance, $memcachedConfig, $container);
        }
    }

    /**
     * Creates a new Memcached definition
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     * @param string $name
     * @param array $config
     *
     * @throws \LogicException
     */
    private function newMemcachedInstance($name, array $config, ContainerBuilder $container)
    {
        // Check if the Memcached extension is loaded
        if (!extension_loaded('memcached')) {
            throw LogicException('Memcached extension is not loaded! To configure memcached instances it MUST be loaded!');
        }

        $memcached = new Definition('Lsw\MemcacheBundle\Cache\LoggingMemcache');
        $memcached->addArgument(new Parameter('kernel.debug'));

        // Check if it has to be persistent
        if (isset($config['persistent_id'])) {
            $memcached->addArgument($config['persistent_id']);
        }

        // Add servers to the memcached instance
        $servers = array();
        foreach ($config['hosts'] as $host) {
            $servers[] = array(
                $host['dsn'],
                $host['port'],
                $host['weight']
            );
        }
        $memcached->addMethodCall('addServers', array($servers));

        $options = $container->getParameter('memcache.default_options');


        // Add memcached options
        if (isset($config['options'])) {

            foreach ($options as $key => $value) {
                if (isset($config['options'][$key])) {
                    $type = gettype($value);
                    if ($key == 'serializer') {
                        if ($value != 'php' && !constant('Memcached::HAVE_' . strtoupper($value))) {
                            throw new \LogicException("Invalid serializer specified for Memcached: $value");
                        }
                        $value = constant('Memcached::SERIALIZER_' . strtoupper($value));
                    } elseif ($key == 'distribution') {
                        $value = constant('Memcached::DISTRIBUTION_' . strtoupper($value));
                    } else {
                        $value = $config['options'][$key];
                    }
                    if ($type!='null') {
                        settype($value,$type);
                        $constant = 'Memcached::OPT_'.strtoupper($key);
                        $memcached->addMethodCall('setOption', array(constant($constant), $value));
                    }
                }
            }

        }
        $serviceName = sprintf('memcache.%s', $name);
        $container->setDefinition($serviceName, $memcached);
        $definition = $container->getDefinition('memcache.data_collector');
        $definition->addMethodCall('addInstance', array($name, new Reference($serviceName)));
    }

}