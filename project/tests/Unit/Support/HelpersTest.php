<?php

namespace Tests\Unit\Support;

use App\Support\CacheManager;
use Mockery\MockInterface;
use Tests\Cases\TestCaseUnit;

class HelpersTest extends TestCaseUnit
{
    public function testCacheManagerInstance()
    {
        $cacheManager = cache_manager();
        $this->assertInstanceOf(CacheManager::class, $cacheManager);
    }

    public function testHelperCacheManagerShouldProxyArgsToCacheManageRememberMethod()
    {
        $callback = function () {
            return 'test';
        };

        $this->mock(CacheManager::class, function (MockInterface $mock) use ($callback) {
            $mock->shouldReceive('remember')
                ->once()
                ->withArgs([
                    \Mockery::mustBe('key'),
                    \Mockery::mustBe('10 seconds'),
                    \Mockery::mustBe($callback),
                    \Mockery::mustBe(['tag']),
                ]);
        });

        cache_manager('key', '10 seconds', $callback, ['tag']);
    }

    public function testInProductionHelper()
    {
        config(['app.env' => 'production']);
        $this->assertTrue(in_production());

        config(['app.env' => 'prod']);
        $this->assertTrue(in_production());

        config(['app.env' => 'homolog']);
        $this->assertFalse(in_production());
    }

    public function testMaskFunction()
    {
        $maskedValue1 = mask('12345678901234', '##.###.###/####-##');
        $maskedValue2 = mask('12345678901234', 'uu.uuu.uuu/uuuu-uu', 'u');

        $this->assertEquals($maskedValue1, '12.345.678/9012-34');
        $this->assertEquals($maskedValue2, '12.345.678/9012-34');
    }

    public function testApplyParamsFunction()
    {
        $this->assertEquals(apply_params('test/:param', ['one']), 'test/one');
        $this->assertEquals(apply_params('test/{first_param}', ['one'], '{', '}'), 'test/one');

        $this->assertEquals(apply_params('test/:first_param/:second_param', ['one', 'two']), 'test/one/two');
        $this->assertEquals(apply_params('test/{first_param}/{second_param}', ['one', 'two'], '{', '}'),
            'test/one/two');
    }
}
