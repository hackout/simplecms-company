# SimpleCMS Company Organization Account Component

📦 The collection breaks down the account module of the organization company, and can achieve various basic information components of multiple enterprises/agents through attachment extensions.

English | [简体中文](./README_zhCN.md)

[![Latest Stable Version](https://poser.pugx.org/simplecms/company/v/stable.svg)](https://packagist.org/packages/simplecms/company) [![Latest Unstable Version](https://poser.pugx.org/simplecms/company/v/unstable.svg)](https://packagist.org/packages/simplecms/company) [![Code Coverage](https://scrutinizer-ci.com/g/overtrue/easy-sms/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/hackout/simplecms-company/?branch=master) [![Total Downloads](https://poser.pugx.org/simplecms/company/downloads)](https://packagist.org/packages/simplecms/company) [![License](https://poser.pugx.org/simplecms/company/license)](https://packagist.org/packages/simplecms/company)

## Requirements

- PHP >= 8.2
- MySQL >= 8.0
- [Laravel/Framework](https://packagist.org/packages/laravel/framework) ^11.0|^12.0
- [SimpleCMS/Framework](https://packagist.org/packages/simplecms/framework) ^2.0
- [Laravel Sanctum](https://packagist.org/packages/laravel/sanctum) ^4.0

## Installation

```bash
composer require simplecms/company
php artisan vendor:publish --tag=simplecms
php artisan migrate
```

This will publish the package migration files and seeders into your Laravel application, and then you can run the database migration to initialize the tables used by the package.

## Usage

### Model Usage

The model inherits ```CompanyAbstract``` to add downward associations to Company.
The naming of downward associations is named in the plural form of camel based on the file name of the Model.
use ```CompanyTrait``` to add upward ```BelongsTo``` associations to the model.

```php
use \SimpleCMS\Company\Abstracts\CompanyAbstract;
use \SimpleCMS\Company\Traits\CompanyTrait;
class Product extends CompanyAbstract
{
    use CompanyTrait;

    //If companyRelations is not set, the default plural form of Product's camel is used, corresponding key is company_id
    public static function companyRelations(){
        return [
            'products' => 'company_id', //Bind a hasMany relationship 'products' to Company, corresponding key is company_id
            'inventories' => 'supplier_id' // Bind a hasMany relationship 'inventories' to Company, corresponding key is supplier_id 
        ];
    }
}
```

### Facades

Account login is completed through the ```CompanyAuthenticatable``` facade, and logging is automatically triggered after a successful login.

```php
use SimpleCMS\Company\Facades\CompanyAuthenticatable;

CompanyAuthenticatable::apiLogin(string $account, string $password, array $messages = []): array;
CompanyAuthenticatable::guardLogin(string $guard, string $account, string $password, array $messages = []): bool|RedirectResponse;
CompanyAuthenticatable::getAccount(CompanyAccount $account): array;
```

### API Login Example

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
    // handle validation or auth failure
}
```

### Logging Events

Logging is automatically handled by adding the ```SimpleCMS\Company\Http\Middleware\CompanyLogMiddleware``` middleware.

```php
Route::middleware(['web', 'company.log'])->group(function () {
    // routes here
});
```

### Models

```php
use SimpleCMS\Company\Models\Company; //Company information
use SimpleCMS\Company\Models\CompanyAccount; //Login account
use SimpleCMS\Company\Models\CompanyApply; //Apply for entry
use SimpleCMS\Company\Models\CompanyLog; //Request log
use SimpleCMS\Company\Models\CompanyProfile; //Company profile
use SimpleCMS\Company\Models\CompanySafe; //Account security information
```

## License

MIT
