<?php

namespace SimpleCMS\Company\Observers;

use SimpleCMS\Company\Models\CompanyAccount;
use SimpleCMS\Company\Packages\CompanyUtil;

class CompanyAccountObserver
{

    /**
     * Handle the CompanyAccount "creating" event.
     */
    public function creating(CompanyAccount $company): void
    {
        if (!$company->uid) {
            $company->uid = CompanyUtil::makeNewUid(CompanyAccount::class);
        }
    }

}
