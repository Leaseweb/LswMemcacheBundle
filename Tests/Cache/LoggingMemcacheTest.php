<?php
namespace Lsw\MemcacheBundle\Tests\Cache;

use Lsw\MemcacheBundle\Cache\LoggingMemcache;

class LoggingMemcacheTest extends \PHPUnit_Framework_TestCase
{
    public function testOpenPort()
    {
    	fsockopen('127.0.0.1', 11211, $errno, $errstr, 0.1);
    } 
	
	public function testGet()
    {
    	$m = new LoggingMemcache(false);
        $m->addServer('localhost', 11211);
        $m->set('key', 'value');
        $value = $m->get('key');
        $this->assertEquals('value', $value);
    }
}