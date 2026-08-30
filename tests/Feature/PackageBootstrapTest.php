<?php

namespace SimpleCMS\Company\Tests\Feature;

use SimpleCMS\Company\Packages\CompanyAuthenticatable;
use SimpleCMS\Company\Tests\TestCase;

class PackageBootstrapTest extends TestCase
{
    public function test_service_provider_is_loaded(): void
    {
        $this->assertTrue($this->app->providerIsLoaded(\SimpleCMS\Company\CompanyServiceProvider::class));
    }

    public function test_company_authenticatable_binding_exists(): void
    {
        $this->assertInstanceOf(CompanyAuthenticatable::class, app('company_authenticatable'));
    }
}
