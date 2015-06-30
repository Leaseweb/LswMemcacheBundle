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
        $cache = new LoggingMemcache('foo',array());

        $this->assertInstanceOf('\MemcachePool', $cache);
        $this->assertInstanceOf('\Lsw\MemcacheBundle\Cache\MemcacheInterface', $cache);
        $this->assertInstanceOf('\Lsw\MemcacheBundle\Cache\LoggingMemcacheInterface', $cache);
    }

    public function testOpenPort()
    {
    	fsockopen('127.0.0.1', 11211, $errno, $errstr, 0.1);
    } 
	
	public function testGet()
    {
    	$m = new LoggingMemcache(false,array());
        $m->addServer('localhost', 11211);
        $m->set('key', 'value');
        $value = $m->get('key');
        $this->assertEquals('value', $value);
    }
}
