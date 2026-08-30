<?php

namespace SimpleCMS\Company\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SimpleCMS\Company\Packages\CompanyAuthenticatable
 */
class CompanyAuthenticatable extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'company_authenticatable';
    }
}
