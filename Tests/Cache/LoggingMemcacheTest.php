<?php

namespace Lsw\MemcacheBundle\Tests\Cache;


use Lsw\MemcacheBundle\Cache\LoggingMemcache;

/**
 * Testing the LoggingMemcache Class.
 *
 * @author Julius Beckmann <github@h4cc.de>
 */
class LoggingMemcacheTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructAndInterfaces()
    {
        $cache = new LoggingMemcache('foo');

        $this->assertInstanceOf('\Memcached', $cache);
        $this->assertInstanceOf('\Lsw\MemcacheBundle\Cache\MemcacheInterface', $cache);
        $this->assertInstanceOf('\Lsw\MemcacheBundle\Cache\LoggingMemcacheInterface', $cache);
    }
}
 