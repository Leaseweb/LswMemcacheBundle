<?php

namespace Lsw\MemcacheBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

/**
 * Defines the configuration options for the Memcached object
 * Based on Emagister\MemcachedBundle by Christian Soronellas
 */
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
            ->append($this->addDoctrineSection())
            ->append($this->addclientsSection())
        ;

        return $treeBuilder;
    }

    /**
     * Configure the "lsw_memcache.clients" section
     *
     * @return ArrayNodeDefinition
     */
    private function addclientsSection()
    {
        $tree = new TreeBuilder();
        $node = $tree->root('clients');

        $node
            ->requiresAtLeastOneElement()
            ->useAttributeAsKey('name')
            ->prototype('array')
                ->children()
                    ->scalarNode('persistent_id')
                        ->defaultNull()
                        ->info('Specify to enable persistent connections. All clients with the same ID share connections.')
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
                                        ->thenInvalid('host port must be numeric')
                                    ->end()
                                ->end()
                                ->scalarNode('weight')
                                    ->defaultValue(0)
                                    ->validate()
                                    ->ifTrue(function ($v) { return !is_numeric($v); })
                                        ->thenInvalid('host weight must be numeric')
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
     * Configure the "lsw_memcache.session" section
     *
     * @return ArrayNodeDefinition
     */
    private function addSessionSupportSection()
    {
        $tree = new TreeBuilder();
        $node = $tree->root('session');

        $node
            ->children()
                ->scalarNode('client')->isRequired()->end()
                ->scalarNode('prefix')->end()
                ->scalarNode('ttl')->end()
                ->booleanNode('locking')->defaultTrue()->end()
                ->scalarNode('spin_lock_wait')->defaultValue(150000)->end()
                ->scalarNode('lock_max_wait')
                    ->defaultNull()
                    ->validate()
                    ->always(function($v) {
                        if (null === $v) {
                            return $v;
                        }

                        if (!is_numeric($v)) {
                            throw new InvalidConfigurationException("Option 'lock_max_wait' must either be NULL or an integer value");
                        }

                        return (int) $v;
                    })
                ->end()
            ->end()
        ->end();

        return $node;
    }

    /**
     * Configure the "lsw_memcache.doctrine" section
     *
     * @return ArrayNodeDefinition
     */
    private function addDoctrineSection()
    {
        $tree = new TreeBuilder();
        $node = $tree->root('doctrine');

        foreach (array('metadata_cache', 'result_cache', 'query_cache') as $type) {
            $node->children()
                ->arrayNode($type)
                    ->canBeUnset()
                    ->children()
                        ->scalarNode('client')->isRequired()->end()
                        ->scalarNode('prefix')->defaultValue('')->end()
                    ->end()
                    ->fixXmlConfig('entity_manager')
                    ->children()
                        ->arrayNode('entity_managers')
                            ->defaultValue(array())
                            ->beforeNormalization()->ifString()->then(function($v) { return (array) $v; })->end()
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                    ->fixXmlConfig('document_manager')
                    ->children()
                        ->arrayNode('document_managers')
                            ->defaultValue(array())
                            ->beforeNormalization()->ifString()->then(function($v) { return (array) $v; })->end()
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
        }

        return $node;
    }

    /**
     * Configure the "lsw_memcache.options" section
     *
     * @return ArrayNodeDefinition
     */
    private function addMemcachedOptionsSection()
    {
        $tree = new TreeBuilder();
        $node = $tree->root('options');

        // Memcached only configs
        $node
            ->children()
                ->booleanNode('compression')->defaultFalse()->end()
                ->scalarNode('serializer')
                    ->defaultValue('php')
                    ->validate()
                    ->ifNotInArray(array('php', 'json', 'igbinary'))
                        ->thenInvalid('serializer option must be: php, json or igbinary')
                    ->end()
                ->end()
                ->scalarNode('prefix_key')->defaultValue('')->end()
                ->scalarNode('hash')
                    ->defaultValue('default')
                    ->validate()
                    ->ifNotInArray(array('default', 'md5', 'crc', 'fnv1_64', 'fnv1a_64', 'fnv1_32', 'fnv1a_32', 'hsieh', 'murmur'))
                        ->thenInvalid('hash option must be: default, md5, crc, fnv1_64, fnv1a_64, fnv1_32, fnv1a_32, hsieh, murmur')
                    ->end()
                ->end()
                ->scalarNode('distribution')
                    ->defaultValue('modula')
                    ->validate()
                    ->ifNotInArray(array('modula', 'consistent'))
                        ->thenInvalid('distribution option must be: modula, consistent')
                    ->end()
                ->end()
                ->booleanNode('libketama_compatible')
                    ->info('Set this to true when using consistent hashing')
                    ->defaultFalse()
                ->end()
                ->booleanNode('buffer_writes')->defaultFalse()->end()
                ->booleanNode('binary_protocol')->defaultFalse()->end()
                ->booleanNode('no_block')->defaultFalse()->end()
                ->booleanNode('tcp_nodelay')->defaultFalse()->end()
                ->scalarNode('socket_send_size')
                    ->defaultNull()
                    ->validate()
                    ->ifTrue(function($v) { return !is_numeric($v); })
                        ->thenInvalid('socket_send_size option must be numeric')
                    ->end()
                ->end()
                ->scalarNode('socket_recv_size')
                    ->defaultNull()
                    ->validate()
                    ->ifTrue(function($v) { return !is_numeric($v); })
                        ->thenInvalid('socket_recv_size option must be numeric')
                    ->end()
                ->end()
                ->scalarNode('connect_timeout')
                    ->defaultValue(1000)
                    ->validate()
                    ->ifTrue(function($v) { return !is_numeric($v); })
                        ->thenInvalid('connect_timeout option must be numeric')
                    ->end()
                ->end()
                ->scalarNode('retry_timeout')
                    ->defaultValue(0)
                    ->validate()
                    ->ifTrue(function($v) { return !is_numeric($v); })
                        ->thenInvalid('retry_timeout option must be numeric')
                    ->end()
                ->end()
                ->scalarNode('send_timeout')
                    ->defaultValue(0)
                    ->validate()
                    ->ifTrue(function($v) { return !is_numeric($v); })
                        ->thenInvalid('send_timeout option must be numeric')
                    ->end()
                ->end()
                ->scalarNode('recv_timeout')
                    ->defaultValue(0)
                    ->validate()
                    ->ifTrue(function($v) { return !is_numeric($v); })
                        ->thenInvalid('recv_timeout option must be numeric')
                    ->end()
                ->end()
                ->scalarNode('poll_timeout')
                    ->defaultValue(1000)
                    ->validate()
                    ->ifTrue(function($v) { return !is_numeric($v); })
                        ->thenInvalid('poll_timeout option must be numeric')
                    ->end()
                ->end()
                ->booleanNode('cache_lookups')->defaultFalse()->end()
                ->scalarNode('server_failure_limit')
                    ->defaultValue(0)
                    ->validate()
                    ->ifTrue(function($v) { return !is_numeric($v); })
                        ->thenInvalid('server_failure_limit option must be numeric')
                    ->end()
                ->end()
            ->end()
        ->end();

        return $node;
    }
}
