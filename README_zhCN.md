# SimpleCMS 公司机构账号组件

📦 集合拆解了机构公司的账号模块，通过附加扩展可实现多种企业/代理的基础信息组件

简体中文 | [English](./README.md)

[![Latest Stable Version](https://poser.pugx.org/simplecms/company/v/stable.svg)](https://packagist.org/packages/simplecms/company) [![Latest Unstable Version](https://poser.pugx.org/simplecms/company/v/unstable.svg)](https://packagist.org/packages/simplecms/company) [![Code Coverage](https://scrutinizer-ci.com/g/overtrue/easy-sms/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/hackout/simplecms-company/?branch=master) [![Total Downloads](https://poser.pugx.org/simplecms/company/downloads)](https://packagist.org/packages/simplecms/company) [![License](https://poser.pugx.org/simplecms/company/license)](https://packagist.org/packages/simplecms/company)

## 环境需求

- PHP >= 8.2
- MySql >= 8.0
- [Laravel/Framework](https://packagist.org/packages/laravel/framework) >= 11.0
- [SimpleCMS/Framework](https://packagist.org/packages/simplecms/framework) >= 1.0

## 安装

```bash
composer require simplecms/company
```

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
}
```

### Facades

账号登录的通过```CompanyAuthenticatable```这个Facade完成，登录后会自动写入日志

```php
use SimpleCMS\Company\Facades\CompanyAuthenticatable; 

CompanyAuthenticatable::apiLogin(string $account, string $password, array $messages = []): array //API接口登录
CompanyAuthenticatable::guardLogin(string $guard, string $account, string $password, array $messages = []): bool|RedirectResponse; //传统AuthGuard登录
CompanyAuthenticatable::getAccount(CompanyAccount $account): array //获取基础返回账号信息
```

### 日志事件

日志操作可以通过增加```SimpleCMS\Company\Http\Middleware\CompanyLogMiddleware```的Middleware进行自动处理

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
