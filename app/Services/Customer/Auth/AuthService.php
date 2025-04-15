<?php

namespace App\Services\Customer\Auth;

use App\Models\Customer;

class AuthService
{
    public function __construct(
        protected Customer $customer,
    )
    {
        
    }

    public function checkVerify($email)
    {
        $customer = $this->customer->where('email', $email)->first();
        if ($customer->email_verified_at == '') {
            return true;
        }
        return false;
    }
}