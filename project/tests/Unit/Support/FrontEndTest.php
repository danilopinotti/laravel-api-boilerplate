<?php

namespace Tests\Unit\Support;

use App\Support\FrontEnd;
use Tests\Cases\TestCaseUnit;

class FrontEndTest extends TestCaseUnit
{
    public function test_should_build_url_when_dont_has_parameters()
    {
        $this->registerRoute('example', '/example');
        $result = FrontEnd::route('example');
        $this->assertEquals('http://tests.local/example', $result);
    }

    public function test_should_build_url_when_has_one_parameter()
    {
        $this->registerRoute('example', '/example/{id}');
        $result = FrontEnd::route('example', 1);
        $this->assertEquals('http://tests.local/example/1', $result);

        $resultUsingArray = FrontEnd::route('example', [1]);
        $this->assertEquals($result, $resultUsingArray);
    }

    public function test_should_build_url_when_route_has_more_than_one_parameters()
    {
        $this->registerRoute('example.multiple', '/example/{id}/bar/{another}');
        $result = FrontEnd::route('example.multiple', [1, 2]);
        $this->assertEquals('http://tests.local/example/1/bar/2', $result);
    }

    public function test_should_fail_when_template_not_found()
    {
        $this->expectExceptionMessage('FrontEnd route [example] does not exists');
        FrontEnd::route('example');
    }

    protected function setUp(): void
    {
        parent::setUp();
        config([
            'app.spa_url' => 'http://tests.local',
        ]);
    }

    private function registerRoute($routeName, $routeTemplate)
    {
        $routes = config('frontend.routes', []);
        $routes[$routeName] = $routeTemplate;

        config(['frontend.routes' => $routes]);
    }
}
