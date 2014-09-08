<?php

namespace Lsw\MemcacheBundle\Tests\Cache;

/**
 * Testing the MemcacheInterface Switch.
 *
 * @author Julius Beckmann <github@h4cc.de>
 */
class MemcacheInterfaceTest extends \PHPUnit_Framework_TestCase
{
    public function testInterfaceWorks()
    {
        $class = new \ReflectionClass('\Lsw\MemcacheBundle\Cache\MemcacheInterface');

        $methods = array_map(
            function (\ReflectionMethod $method) {
                return $method->getName();
            },
            $class->getMethods()
        );

        foreach ($this->getDefaultMethods() as $method) {
            $this->assertContains($method, $methods);
        }
    }

    private function getDefaultMethods()
    {
        return array(
            'get',
            'getByKey',
            'getMulti',
            'getMultiByKey',
            'getDelayed',
            'getDelayedByKey',
            'fetch',
            'fetchAll',
            'set',
            'setByKey',
            'setMulti',
            'setMultiByKey',
            'cas',
            'casByKey',
            'add',
            'addByKey',
            'append',
            'appendByKey',
            'prepend',
            'prependByKey',
            'replace',
            'replaceByKey',
            'delete',
            'deleteByKey',
            'increment',
            'decrement',
            'getOption',
            'setOption',
            'addServer',
            'addServers',
            'getServerList',
            'getServerByKey',
            'flush',
            'getStats',
            'getResultCode',
            'getResultMessage',
        );
    }
}
 