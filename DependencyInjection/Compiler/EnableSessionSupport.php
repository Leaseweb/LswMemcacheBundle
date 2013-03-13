<?php

namespace Lsw\MemcacheBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * EnableSessionSupport is a compiler pass to set the session handler.
 * Based on Emagister\MemcachedBundle by Christian Soronellas
 */
class EnableSessionSupport implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        // If no handler type specified or no is active session support, return
        if (!$container->hasAlias('session.storage')) {
            return;
        }

        $container->setAlias('session.handler', 'memcache.session_handler');
    }
}