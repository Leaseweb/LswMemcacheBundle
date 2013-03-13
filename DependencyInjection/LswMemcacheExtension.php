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
 * {@inheritDoc}
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
        $loader->load('services.yml');

        if (isset($config['session_support']) && true === $config['session_support']['enabled']) {
            if (!isset($config['instances']) || !isset($config['instances'][$config['session_support']['instance_id']])) {
                throw new \LogicException(sprintf('The instance "%s" does not exist! Cannot enable the session support!', $config['session_support']['instance_id']));
            }
            $options = $config['session_support']['options'];
            $this->enableSessionSupport($config['session_support']['instance_id'], $options, $container);
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

        // Add memcached options
        if (isset($config['options'])) {
            $memcached->addMethodCall('setOption', array(constant('Memcached::OPT_COMPRESSION'), (bool) $config['options']['compression']));

            if ('php' != $config['options']['serializer']
                && false === constant('Memcached::HAVE_' . strtoupper($config['options']['serializer']))
            ) {
                throw new \LogicException('Invalid serializer specified for Memcached: ' . $config['options']['serializer']);
            }

            $memcached->addMethodCall('setOption', array(constant('Memcached::OPT_SERIALIZER'), constant('Memcached::SERIALIZER_' . strtoupper($config['options']['serializer']))));
            $memcached->addMethodCall('setOption', array(constant('Memcached::OPT_PREFIX_KEY'), $config['options']['prefix_key']));
            $memcached->addMethodCall('setOption', array(constant('Memcached::OPT_HASH'), constant('Memcached::HASH_' . strtoupper($config['options']['hash']))));
            $memcached->addMethodCall('setOption', array(constant('Memcached::OPT_DISTRIBUTION'), strtoupper('Memcached::DISTRIBUTION_' . $config['options']['distribution'])));

            if ('consistent' == $config['options']['distribution']) {
                $config['options']['libketama_compatible'] = true;
            }

            $memcached->addMethodCall('setOption', array(constant('Memcached::OPT_LIBKETAMA_COMPATIBLE'), (bool) $config['options']['libketama_compatible']));
            $memcached->addMethodCall('setOption', array(constant('Memcached::OPT_BUFFER_WRITES'), (bool) $config['options']['buffer_writes']));
            $memcached->addMethodCall('setOption', array(constant('Memcached::OPT_BINARY_PROTOCOL'), (bool) $config['options']['binary_protocol']));
            $memcached->addMethodCall('setOption', array(constant('Memcached::OPT_NO_BLOCK'), (bool) $config['options']['no_block']));
            $memcached->addMethodCall('setOption', array(constant('Memcached::OPT_TCP_NODELAY'), (bool) $config['options']['tcp_nodelay']));
            if (null !== $config['options']['socket_send_size']) {
                $memcached->addMethodCall('setOption', array(constant('Memcached::OPT_SOCKET_SEND_SIZE'), $config['options']['socket_send_size']));
            }
            if (null !== $config['options']['socket_recv_size']) {
                $memcached->addMethodCall('setOption', array(constant('Memcached::OPT_SOCKET_RECV_SIZE'), $config['options']['socket_recv_size']));
            }
            $memcached->addMethodCall('setOption', array(constant('Memcached::OPT_CONNECT_TIMEOUT'), $config['options']['connect_timeout']));

            if ($config['options']['retry_timeout'] > 0) {
                $memcached->addMethodCall('setOption', array(constant('Memcached::OPT_RETRY_TIMEOUT'), $config['options']['retry_timeout']));
            }

            $memcached->addMethodCall('setOption', array(constant('Memcached::OPT_SEND_TIMEOUT'), $config['options']['send_timeout']));
            $memcached->addMethodCall('setOption', array(constant('Memcached::OPT_RECV_TIMEOUT'), $config['options']['recv_timeout']));
            $memcached->addMethodCall('setOption', array(constant('Memcached::OPT_POLL_TIMEOUT'), $config['options']['poll_timeout']));

            if (true === (bool) $config['options']['cache_lookups']) {
                $memcached->addMethodCall('setOption', array(constant('Memcached::OPT_CACHE_LOOKUPS'), true));
            }

            if ($config['options']['server_failure_limit'] > 0) {
                $memcached->addMethodCall('setOption', array(constant('Memcached::OPT_SERVER_FAILURE_LIMIT'), $config['options']['server_failure_limit']));
            }
        }
        $serviceName = sprintf('memcache.%s', $name);
        $container->setDefinition($serviceName, $memcached);
        $definition = $container->getDefinition('memcache.data_collector');
        $definition->addMethodCall('addInstance', array($name, new Reference($serviceName)));
    }

}