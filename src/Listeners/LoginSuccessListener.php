<?php

namespace SimpleCMS\Company\Listeners;

use SimpleCMS\Company\Events\LoginSuccess;
use Illuminate\Contracts\Queue\ShouldQueue;
use SimpleCMS\Company\Packages\CompanyLogWrite;

class LoginSuccessListener implements ShouldQueue
{

    /**
     * Handle the event.
     */
    public function handle(LoginSuccess $event): void
    {
        CompanyLogWrite::makeLog(true,$event->account);
    }
}
