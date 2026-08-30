# SimpleCMS 公司机构账号组件

📦 集合拆解了机构公司的账号模块，通过附加扩展可实现多种企业/代理的基础信息组件

简体中文 | [English](./README.md)

[![Latest Stable Version](https://poser.pugx.org/simplecms/company/v/stable.svg)](https://packagist.org/packages/simplecms/company) [![Latest Unstable Version](https://poser.pugx.org/simplecms/company/v/unstable.svg)](https://packagist.org/packages/simplecms/company) [![Code Coverage](https://scrutinizer-ci.com/g/overtrue/easy-sms/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/hackout/simplecms-company/?branch=master) [![Total Downloads](https://poser.pugx.org/simplecms/company/downloads)](https://packagist.org/packages/simplecms/company) [![License](https://poser.pugx.org/simplecms/company/license)](https://packagist.org/packages/simplecms/company)

## 环境需求

- PHP >= 8.2
- MySQL >= 8.0
- [Laravel/Framework](https://packagist.org/packages/laravel/framework) ^11.0|^12.0
- [SimpleCMS/Framework](https://packagist.org/packages/simplecms/framework) ^2.0
- [Laravel Sanctum](https://packagist.org/packages/laravel/sanctum) ^4.0

## 安装

```bash
composer require simplecms/company
php artisan vendor:publish --tag=simplecms
php artisan migrate
```

如果你需要在应用中直接使用该组件的数据库表结构，发布资源后会同步生成迁移文件和种子文件，随后再执行迁移即可。

## 使用方法

### Model模型使用

模型继承```CompanyAbstract```以增加Company的向下关联

向下关联中的命名以Model的文件名进行的camel复数形态命名。

使用```CompanyTrait```对模型进行向上```BelongsTo```关联

```php
use \SimpleCMS\Company\Abstracts\CompanyAbstract;
use \SimpleCMS\Company\Traits\CompanyTrait;

class Product extends CompanyAbstract
{
    use CompanyTrait;

    //不设置companyRelations时默认 Product的camel复数形态，对应键company_id
    public static function companyRelations(){
        return [
            'products' => 'company_id', //为Company绑定一个products的hasMany下级关系，对应键为company_id 
            'inventories' => 'supplier_id' // 为Company绑定一个inventories的hasMany下级关系，对应键为supplier_id
        ];
    }
}
```

### Facades

账号登录通过 ```CompanyAuthenticatable``` Facade 完成，成功后会自动分发登录和日志事件。

```php
use SimpleCMS\Company\Facades\CompanyAuthenticatable;

CompanyAuthenticatable::apiLogin(string $account, string $password, array $messages = []): array;
CompanyAuthenticatable::guardLogin(string $guard, string $account, string $password, array $messages = []): bool|RedirectResponse;
CompanyAuthenticatable::getAccount(CompanyAccount $account): array;
```

### API 登录示例

```php
use SimpleCMS\Company\Facades\CompanyAuthenticatable;

try {
    $payload = CompanyAuthenticatable::apiLogin('company-admin', 'secret123');
    // [
    //   'token' => '...',
    //   'finger' => '...',
    //   'user' => [...]
    // ]
} catch (\Throwable $e) {
    // 处理账号不存在 / 密码错误 / 账号不可用
}
```

### 日志事件

通过增加 ```SimpleCMS\Company\Http\Middleware\CompanyLogMiddleware``` 中间件即可自动写入请求日志。

```php
Route::middleware(['web', 'company.log'])->group(function () {
    // 路由定义
});
```

### Models

```php
use SimpleCMS\Company\Models\Company; //公司信息
use SimpleCMS\Company\Models\CompanyAccount; //登录账号
use SimpleCMS\Company\Models\CompanyApply; //申请入驻
use SimpleCMS\Company\Models\CompanyLog; //请求日志
use SimpleCMS\Company\Models\CompanyProfile; //公司资料
use SimpleCMS\Company\Models\CompanySafe; //账号密保信息
```

## License

MIT
