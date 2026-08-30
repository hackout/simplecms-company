<?php

namespace SimpleCMS\Company\Listeners;

use SimpleCMS\Company\Events\LoginFailed;
use Illuminate\Contracts\Queue\ShouldQueue;
use SimpleCMS\Company\Packages\CompanyLogWrite;

class LoginFailedListener implements ShouldQueue
{

    /**
     * Handle the event.
     */
    public function handle(LoginFailed $event): void
    {
        CompanyLogWrite::makeLog(false,$event->account);
    }
}
