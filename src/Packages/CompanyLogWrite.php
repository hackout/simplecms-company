<?php
namespace SimpleCMS\Company\Packages;

use Illuminate\Http\Request;
use SimpleCMS\Company\Models\CompanyLog;
use SimpleCMS\Framework\Attributes\ApiName;
use SimpleCMS\Company\Models\CompanyAccount;
use SimpleCMS\Company\Enums\CompanyLogMethodEnum;

class CompanyLogWrite
{

    /**
     * 写入日志
     * @param bool $status 请求状态
     * @param \SimpleCMS\Company\Models\CompanyAccount|null $account 登录账号
     * @return void
     */
    public static function makeLog(bool $status, CompanyAccount $account = null): void
    {
        $request = request();
        $controllerName = optional($request->route())->getControllerClass();
        $actionName = optional($request->route())->getActionMethod();
        if (!empty($controllerName) && !empty($actionName)) {
            static::applyLog($request, $status, $controllerName, $actionName, $account);
        }
    }

    private static function applyLog(Request $request, bool $status, string $controllerName, string $actionName, CompanyAccount $account = null): void
    {
        if (method_exists($controllerName, $actionName)) {
            $reflectionMethod = new \ReflectionMethod($controllerName, $actionName);
            $attributes = $reflectionMethod->getAttributes(ApiName::class);
            $name = $controllerName . '@' . $actionName;
            foreach ($attributes as $attribute) {

                if ($attribute->getName() === ApiName::class) {
                    $name = $attribute->getArguments()['name'];
                }
            }
            $sql = static::makeSql($request, $name, $status, $account);

            CompanyLog::create($sql);
        }
    }

    private static function makeSql(Request $request, string|null $name = null, bool $status = false, CompanyAccount $account = null): array
    {
        $account = empty($account) ? optional($request->user()) : optional($account);
        return [
            'company_id' => $account->company_id,
            'company_account_id' => $account->id,
            'name' => $name,
            'user_agent' => $request->userAgent(),
            'ip_address' => $request->getClientIp(),
            'method' => CompanyLogMethodEnum::getValue($request->getMethod())->value,
            'url' => $request->route()->uri,
            'parameters' => $request->all(),
            'route_name' => $request->route()->getName(),
            'status' => $status
        ];
    }
}