<?php

namespace Lsw\MemcacheBundle\Tests\Cache;


use Lsw\MemcacheBundle\Cache\MemcacheManager;
use Lsw\MemcacheBundle\Cache\LoggingMemcache;

/**
 * Testing the MemcacheManager Class.
 *
 * @author David Geistert <david@geistert.info>
 */
class MemcacheManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $cache = new LoggingMemcache(false);
        $cache->addServer('localhost', '11211');
        $cacheManager = new MemcacheManager();

        $this->assertEquals(array(), $cacheManager->getMemcaches());

        $cacheManager->addMemcachePool('foo', $cache);

        $this->assertArrayHasKey('foo', $cacheManager->getMemcaches());
        $this->assertEquals($cache, $cacheManager->getMemcache('foo'));

        return array($cache, $cacheManager);
    }

    /**
     * @depends testConstruct
     */
	public function testFlush($args)
    {
        list($cache, $cacheManager) = $args;

        $cache->set('key', 'value');
        $this->assertEquals('value', $cache->get('key'));

        $this->assertFalse($cacheManager->flushMemcache('bar'));
        $this->assertTrue($cacheManager->flushMemcache('foo'));
        $this->assertFalse($cache->get('key'));

        $cache->set('key', 'value');
        $this->assertEquals('value', $cache->get('key'));
        $cacheManager->flushAllMemcaches();

        $this->assertFalse($cache->get('key'));

    }
}
