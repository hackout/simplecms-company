<?php

namespace SimpleCMS\Company\Events;

use Illuminate\Queue\SerializesModels;
use SimpleCMS\Company\Models\CompanyAccount;
use Illuminate\Foundation\Events\Dispatchable;

class ApiLogin
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public CompanyAccount $account)
    {
        //
    }
}
