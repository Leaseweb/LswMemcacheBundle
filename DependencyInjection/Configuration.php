<?php

namespace Lsw\MemcacheBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('lsw_memcache');

        $rootNode
            ->append($this->addSessionSupportSection())
            ->append($this->addInstancesSection())
        ;

        return $treeBuilder;
    }

    /**
     * Configure the "instances" section
     *
     * @return ArrayNodeDefinition
     */
    private function addInstancesSection()
    {
        $tree = new TreeBuilder();
        $node = $tree->root('instances');

        $node
            ->requiresAtLeastOneElement()
            ->useAttributeAsKey('name')
            ->prototype('array')
                ->children()
                    ->scalarNode('persistent_id')
                        ->defaultNull()
                        ->info('Specify to enable persistent connections. All instances with the same ID share connections.')
                    ->end()
                    ->arrayNode('hosts')
                        ->requiresAtLeastOneElement()
                        ->prototype('array')
                            ->children()
                                ->scalarNode('dsn')->cannotBeEmpty()->isRequired()->end()
                                ->scalarNode('port')
                                    ->cannotBeEmpty()
                                    ->defaultValue(11211)
                                    ->validate()
                                    ->ifTrue(function ($v) { return !is_numeric($v); })
                                        ->thenInvalid('Memcached port must be a valid integer!')
                                    ->end()
                                ->end()
                                ->scalarNode('weight')
                                    ->defaultValue(0)
                                    ->validate()
                                    ->ifTrue(function ($v) { return !is_numeric($v); })
                                        ->thenInvalid('Memcached weight must be a valid integer!')
                                    ->end()
                                ->end()
                                ->arrayNode('memcache_options')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->booleanNode('persistent')->defaultTrue()->end()
                                        ->scalarNode('timeout')
                                            ->defaultValue(1)
                                            ->validate()
                                            ->ifTrue(function ($v) { return !is_numeric($v); })
                                                ->thenInvalid('Memcache timeout must be a valid integer!')
                                            ->end()
                                        ->end()
                                        ->scalarNode('retry_interval')
                                            ->defaultValue(15)
                                            ->validate()
                                            ->ifTrue(function ($v) { return !is_numeric($v); })
                                                ->thenInvalid('Memcache retry interval must be a valid integer!')
                                            ->end()
                                        ->end()
                                        ->booleanNode('status')->defaultTrue()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                    ->append($this->addMemcachedOptionsSection())
                ->end()
            ->end()
        ->end();

        return $node;
    }

    /**
     * Configure the "session_support" section
     *
     * @return ArrayNodeDefinition
     */
    private function addSessionSupportSection()
    {
        $tree = new TreeBuilder();
        $node = $tree->root('session_support');

        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('instance')->defaultNull()->end()
                ->arrayNode('options')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('prefix')
                            ->defaultValue('session_')
                            ->isRequired()
                        ->end()
                        ->scalarNode('expiretime')
                            ->defaultValue('86400')
                            ->isRequired()
                            ->validate()
                            ->ifTrue(function ($v) { return !is_int($v); })
                                ->thenInvalid('The expiretime parameter must be an integer!')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $node;
    }

    /**
     * Configure the "memcached_options" section
     *
     * @return ArrayNodeDefinition
     */
    private function addMemcachedOptionsSection()
    {
        $tree = new TreeBuilder();
        $node = $tree->root('options');

        // Memcached only configs
        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->booleanNode('compression')->defaultTrue()->end()
                ->scalarNode('serializer')
                    ->defaultValue('json')
                    ->validate()
                    ->ifNotInArray(array('php', 'json', 'igbinary'))
                        ->thenInvalid('Invalid value for serializer')
                    ->end()
                ->end()
                ->scalarNode('prefix_key')->defaultValue('cache_')->end()
                ->scalarNode('hash')
                    ->defaultValue('default')
                    ->validate()
                    ->ifNotInArray(array('default', 'md5', 'crc', 'fnv1_64', 'fnv1a_64', 'fnv1_32', 'fnv1a_32', 'hsieh', 'murmur'))
                        ->thenInvalid('Invalid value for hash!')
                    ->end()
                ->end()
                ->scalarNode('distribution')
                    ->defaultValue('consistent')
                    ->validate()
                    ->ifNotInArray(array('modula', 'consistent'))
                        ->thenInvalid('Must be either modula or consistent')
                    ->end()
                ->end()
                ->booleanNode('libketama_compatible')
                    ->info('It is highly recommended to enable this option if you want to use consistent hashing, and it may be enabled by default in future releases.')
                    ->defaultTrue()
                ->end()
                ->booleanNode('buffer_writes')->defaultTrue()->end()
                ->booleanNode('binary_protocol')->defaultTrue()->end()
                ->booleanNode('no_block')->defaultTrue()->end()
                ->booleanNode('tcp_nodelay')->defaultFalse()->end()
                ->scalarNode('socket_send_size')
                    ->defaultNull()
                    ->validate()
                    ->ifTrue(function($v) { return !is_numeric($v); })
                        ->thenInvalid('Must be number!')
                    ->end()
                ->end()
                ->scalarNode('socket_recv_size')
                    ->defaultNull()
                    ->validate()
                    ->ifTrue(function($v) { return !is_numeric($v); })
                        ->thenInvalid('Must be number!')
                    ->end()
                ->end()
                ->scalarNode('connect_timeout')
                    ->defaultValue(1000)
                    ->validate()
                    ->ifTrue(function($v) { return !is_numeric($v); })
                        ->thenInvalid('Must be number!')
                    ->end()
                ->end()
                ->scalarNode('retry_timeout')
                    ->defaultValue(0)
                    ->validate()
                    ->ifTrue(function($v) { return !is_numeric($v); })
                        ->thenInvalid('Must be number!')
                    ->end()
                ->end()
                ->scalarNode('send_timeout')
                    ->defaultValue(0)
                    ->validate()
                    ->ifTrue(function($v) { return !is_numeric($v); })
                        ->thenInvalid('Must be number!')
                    ->end()
                ->end()
                ->scalarNode('recv_timeout')
                    ->defaultValue(0)
                    ->validate()
                    ->ifTrue(function($v) { return !is_numeric($v); })
                        ->thenInvalid('Must be number!')
                    ->end()
                ->end()
                ->scalarNode('poll_timeout')
                    ->defaultValue(1000)
                    ->validate()
                    ->ifTrue(function($v) { return !is_numeric($v); })
                        ->thenInvalid('Must be number!')
                    ->end()
                ->end()
                ->booleanNode('cache_lookups')->defaultFalse()->end()
                ->scalarNode('server_failure_limit')
                    ->defaultValue(0)
                    ->validate()
                    ->ifTrue(function($v) { return !is_numeric($v); })
                        ->thenInvalid('Must be number!')
                    ->end()
                ->end()
            ->end()
        ->end();

        return $node;
    }
}