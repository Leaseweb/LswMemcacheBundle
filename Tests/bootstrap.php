<?php
/*
 * This file bootstraps the test environment.
 */

error_reporting(E_ALL);

// for hhvm compatibility
if (!class_exists('MemcachePool',false)){
    class \MemcachePool extends \Memcache {};
}

require __DIR__.'/../vendor/autoload.php';
