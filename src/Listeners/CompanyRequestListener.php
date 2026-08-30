<?php

namespace SimpleCMS\Company\Listeners;

use SimpleCMS\Company\Events\CompanyRequest;
use SimpleCMS\Company\Packages\CompanyLogWrite;

class CompanyRequestListener
{

    /**
     * Handle the event.
     */
    public function handle(CompanyRequest $event): void
    {
        CompanyLogWrite::makeLog($event->status, $event->request->user());
    }
}
