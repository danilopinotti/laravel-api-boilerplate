<?php

namespace Tests\Feature;

use Tests\Cases\TestCaseFeature;

class ExampleTest extends TestCaseFeature
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
