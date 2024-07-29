<?php

namespace SimpleCMS\Company\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use SimpleCMS\Company\Events\LoginFailed;
use Illuminate\Contracts\Queue\ShouldQueue;
use SimpleCMS\Company\Packages\CompanyLogWrite;

class LoginFailedListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(LoginFailed $event): void
    {
        CompanyLogWrite::makeLog(false,$event->account);
    }
}
