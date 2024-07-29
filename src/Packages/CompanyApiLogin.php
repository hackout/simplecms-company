<?php
namespace SimpleCMS\Company\Packages;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use SimpleCMS\Company\Models\CompanyAccount;
use SimpleCMS\Framework\Exceptions\SimpleException;
use SimpleCMS\Framework\Packages\Finger\Finger;
use Symfony\Component\HttpFoundation\RedirectResponse;


class CompanyApiLogin
{
    /**
     * 获取登录token及基础信息
     * @param \SimpleCMS\Company\Models\CompanyAccount $account
     * @return array
     */
    public static function getLoginInfo(CompanyAccount $account): array
    {
        $token = $account->createToken('company_api');
        return [
            'token' => $token->plainTextToken,
            'finger' => Finger::getFinger(),
            'user' => (new CompanyAuthenticatable)->getAccount($account)
        ];
    }

}