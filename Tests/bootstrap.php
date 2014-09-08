<?php
/*
 * This file bootstraps the test environment.
 */
namespace Lsw\MemcacheBundle\Tests;

error_reporting(E_ALL | E_STRICT);

// register silently failing autoloader
spl_autoload_register(function($class)
{
	if (0 === strpos($class, 'Lsw\\MemcacheBundle\\')) {
        $path = __DIR__.'/../../../'.strtr($class, '\\', '/').'.php';
        
        if (is_file($path) && is_readable($path)) {
            require_once $path;

            return true;
        }
    }
});