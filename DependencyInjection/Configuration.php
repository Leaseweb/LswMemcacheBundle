<?php

namespace Lsw\MemcacheBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

/**
 * Defines the configuration options for the Memcache object
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
            ->append($this->addClientsSection())
        ;

        return $treeBuilder;
    }

    /**
     * Configure the "lsw_memcache.pools" section
     *
     * @return ArrayNodeDefinition
     */
    private function addClientsSection()
    {
        $tree = new TreeBuilder();
        $node = $tree->root('pools');

        $node
            ->requiresAtLeastOneElement()
            ->useAttributeAsKey('name')
            ->prototype('array')
                ->children()
                    ->arrayNode('servers')
                        ->requiresAtLeastOneElement()
                        ->prototype('array')
                            ->children()
                                ->scalarNode('host')
                                	->cannotBeEmpty()
                                	->isRequired()
                               	->end()
                                ->scalarNode('port')
                                    ->cannotBeEmpty()
                                    ->defaultValue(11211)
                                    ->validate()
                                    ->ifTrue(function ($v) { return !is_numeric($v); })
                                        ->thenInvalid('port must be numeric')
                                    ->end()
                                ->end()
                                ->booleanNode('persistent')
                                	->defaultTrue()
                                ->end()
                                ->scalarNode('weight')
                                    ->defaultValue(1)
                                    ->validate()
                                    ->ifTrue(function ($v) { return !is_numeric($v); })
                                        ->thenInvalid('weight must be numeric')
                                    ->end()
                                ->end()
                                ->scalarNode('timeout')
	                                ->defaultValue(1)
	                                ->validate()
	                                ->ifTrue(function ($v) { return !is_numeric($v); })
	                                	->thenInvalid('timeout must be numeric')
	                                ->end()
                                ->end()
                                ->scalarNode('retry_interval')
	                                ->defaultValue(15)
	                                ->validate()
	                                ->ifTrue(function ($v) { return !is_numeric($v); })
	                                	->thenInvalid('retry_interval must be numeric')
	                                ->end()
                                ->end()
                        	->end()
                        ->end()
                    ->end()
                    ->append($this->addMemcacheOptionsSection())
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
                ->scalarNode('pool')->isRequired()->end()
                ->booleanNode('autoload')->defaultTrue()->end()
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
                        ->scalarNode('pool')->isRequired()->end()
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
    private function addMemcacheOptionsSection()
    {
        $tree = new TreeBuilder();
        $node = $tree->root('options');

        // Memcache only configs
        
        $node
            ->children()
	            ->booleanNode('allow_failover')->defaultTrue()->end()
                ->scalarNode('max_failover_attempts')
		            ->defaultValue(20)
		            ->validate()
		            ->ifTrue(function($v) { return !is_numeric($v); })
		            	->thenInvalid('max_failover_attempts option must be numeric')
		            ->end()
	            ->end()            
                ->scalarNode('default_port')
		            ->defaultValue(11211)
		            ->validate()
		            ->ifTrue(function($v) { return !is_numeric($v); })
		            	->thenInvalid('default_port option must be numeric')
		            ->end()
	            ->end()            
                ->scalarNode('chunk_size')
		            ->defaultValue(32768)
		            ->validate()
		            ->ifTrue(function($v) { return !is_numeric($v); })
		            	->thenInvalid('chunk_size option must be numeric')
		            ->end()
	            ->end()     
                ->scalarNode('protocol')
                    ->defaultValue('ascii')
                    ->validate()
                    ->ifNotInArray(array('ascii', 'binary'))
                        ->thenInvalid('protocol option must be: ascii or binary')
                    ->end()
                ->end()     
                ->scalarNode('hash_strategy')
                    ->defaultValue('consistent')
                    ->validate()
                    ->ifNotInArray(array('standard', 'consistent'))
                        ->thenInvalid('hash_strategy option must be: standard or consistent')
                    ->end()
                ->end()     
                ->scalarNode('hash_function')
                    ->defaultValue('crc32')
                    ->validate()
                    ->ifNotInArray(array('crc32', 'fnv'))
                        ->thenInvalid('hash_function option must be: crc32 or fnv')
                    ->end()
                ->end()            
                ->booleanNode('redundancy')->defaultTrue()->end()            
                ->scalarNode('session_redundancy')
		            ->defaultValue(2)
		            ->validate()
		            ->ifTrue(function($v) { return !is_numeric($v); })
		            	->thenInvalid('session_redundancy option must be numeric')
		            ->end()
	            ->end()             
                ->scalarNode('compress_threshold')
		            ->defaultValue(20000)
		            ->validate()
		            ->ifTrue(function($v) { return !is_numeric($v); })
		            	->thenInvalid('compress_threshold option must be numeric')
		            ->end()
	            ->end()             
                ->scalarNode('lock_timeout')
		            ->defaultValue(15)
		            ->validate()
		            ->ifTrue(function($v) { return !is_numeric($v); })
		            	->thenInvalid('lock_timeout option must be numeric')
		            ->end()
	            ->end() 
            ->end()
        ->end();

        return $node;
    }
}
