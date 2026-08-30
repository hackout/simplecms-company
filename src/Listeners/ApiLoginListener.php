<?php

namespace SimpleCMS\Company\Listeners;

use SimpleCMS\Company\Events\ApiLogin;
use SimpleCMS\Company\Packages\CompanyApiLogin;

class ApiLoginListener
{

    /**
     * Handle the event.
     */
    public function handle(ApiLogin $event): array
    {
        return CompanyApiLogin::getLoginInfo($event->account);
    }
}
