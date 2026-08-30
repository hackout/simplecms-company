<?php

namespace SimpleCMS\Company\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use SimpleCMS\Company\CompanyServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            CompanyServiceProvider::class,
        ];
    }
}
