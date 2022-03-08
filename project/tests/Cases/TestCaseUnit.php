<?php

namespace Tests\Cases;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\CreatesApplication;

abstract class TestCaseUnit extends BaseTestCase
{
    use CreatesApplication;
}
