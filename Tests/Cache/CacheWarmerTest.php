<?php

namespace AssoConnect\ValidatorBundle\Test\Cache;

use AssoConnect\ValidatorBundle\Cache\CacheWarmer;
use PHPUnit\Framework\TestCase;

class CacheWarmerTest extends TestCase
{
    private const CACHE_FOLDER = 'xxx/yyy';

    private $testedInstance;

    protected function setUp()
    {
        $this->testedInstance = new CacheWarmer(self::CACHE_FOLDER);
    }

    public function testItIsNotOptional()
    {
        $this->assertFalse($this->testedInstance->isOptional());
    }

    public function testItWarmTheCorrectFolder()
    {
        $this->testedInstance->warmUp(dirname(__FILE__) . '/tmp');

        $this->assertTrue(is_dir(dirname(__FILE__) . '/tmp/' . self::CACHE_FOLDER));

        rmdir(dirname(__FILE__) . '/tmp/xxx/yyy');
        rmdir(dirname(__FILE__) . '/tmp/xxx');
        rmdir(dirname(__FILE__) . '/tmp');
    }
}
