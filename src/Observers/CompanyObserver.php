<?php

namespace SimpleCMS\Company\Observers;

use SimpleCMS\Company\Models\Company;
use SimpleCMS\Company\Packages\CompanyUtil;

class CompanyObserver
{

    /**
     * Handle the Company "creating" event.
     */
    public function creating(Company $company): void
    {
        if(!$company->uid)
        {
            $company->uid = CompanyUtil::makeNewUid(Company::class);
        }
    }

}
