<?php

namespace Lsw\MemcacheBundle\Tests\Cache;


use Lsw\MemcacheBundle\Cache\AntiDogPileMemcache;

/**
 * Testing the AntiDogPileMemcache Class.
 *
 * @author Julius Beckmann <github@h4cc.de>
 */
class AntiDogPileMemcacheTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructAndInterfaces()
    {
        $cache = new AntiDogPileMemcache('foo',array());

        $this->assertInstanceOf('\Lsw\MemcacheBundle\Cache\LoggingMemcache', $cache);
    }
}
 