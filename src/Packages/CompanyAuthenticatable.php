<?php
namespace SimpleCMS\Company\Packages;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use SimpleCMS\Company\Models\CompanyAccount;
use SimpleCMS\Framework\Exceptions\SimpleException;
use Symfony\Component\HttpFoundation\RedirectResponse;


class CompanyAuthenticatable
{
    /**
     * API 登录
     * @param string $account
     * @param string $password
     * @param array $messages
     * @throws \SimpleCMS\Framework\Exceptions\SimpleException
     * @return array
     */
    public function apiLogin(string $account, string $password, array $messages = []): array
    {
        $errorMessages = array_merge([
            'not_found' => 'The account or password is incorrect.',
            'password_incorrect' => 'The account or password is incorrect.',
            'account_invalid' => 'The account has been locked by the system and you can not log on.'
        ], $messages);
        $account = CompanyAccount::where('account', $account)->first();
        if (!$account) {
            event('simplecms.plugin.company.login_failed', $account);
            throw new SimpleException($errorMessages['not_found']);
        }
        if (!Hash::check($password, $account->password)) {
            event('simplecms.plugin.company.login_failed', $account);
            throw new SimpleException($errorMessages['password_incorrect']);
        }
        if (!$account->is_valid || optional($account->company)->is_valid !== true) {
            event('simplecms.plugin.company.login_failed', $account);
            throw new SimpleException($errorMessages['account_invalid']);
        }
        event('simplecms.plugin.company.login_success', $account);
        return (array) event('simplecms.plugin.company.api_login', $account);
    }

    /**
     * Guard 登录
     * @param string $guard
     * @param string $account
     * @param string $password
     * @param array $messages
     * @throws \SimpleCMS\Framework\Exceptions\SimpleException
     * @return bool|RedirectResponse
     */
    public function guardLogin(string $guard, string $account, string $password, array $messages = []): bool|RedirectResponse
    {
        $errorMessages = array_merge([
            'not_found' => 'The account or password is incorrect.',
            'password_incorrect' => 'The account or password is incorrect.',
            'account_invalid' => 'The account has been locked by the system and you can not log on.'
        ], $messages);
        $account = CompanyAccount::where('account', $account)->first();
        if (!$account) {
            event('simplecms.plugin.company.login_failed', $account);
            return back()->withErrors($errorMessages['not_found']);
        }
        if (!Auth::guard($guard)->attempt(['account' => $account, 'password' => $password, 'is_valid' => true])) {
            return back()->withErrors($errorMessages['password_incorrect']);
        }
        if (!$account->is_valid || optional($account->company)->is_valid !== true) {
            event('simplecms.plugin.company.login_failed', $account);
            return back()->withErrors($errorMessages['account_invalid']);
        }
        event('simplecms.plugin.company.login_success', $account);
        return true;
    }

    /**
     * 获取账号基础信息
     * @param \SimpleCMS\Company\Models\CompanyAccount $account
     * @return array
     */
    public function getAccount(CompanyAccount $account): array
    {
        return [
            'company_name' => optional($account->company)->name,
            'company_id' => $account->company_id,
            'uid' => $account->uid,
            'avatar' => $account->avatar,
            'account' => $account->account,
            'name' => $account->name,
            'roles' => $account->roles,
            'is_valid' => $account->is_valid,
            'is_founder' => $account->is_founder,
            'last_login' => $account->last_login,
            'last_ip' => $account->last_ip,
            'register_at' => $account->created_at,
            'register_ip' => $account->register_ip,
            'register_finger' => $account->register_finger,
        ];
    }
}