<?php

namespace SimpleCMS\Company;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Event;
use SimpleCMS\Company\Models\Company;
use SimpleCMS\Company\Events\ApiLogin;
use Illuminate\Support\ServiceProvider;
use SimpleCMS\Company\Events\LoginFailed;
use SimpleCMS\Company\Events\LoginSuccess;
use SimpleCMS\Company\Events\CompanyRequest;
use SimpleCMS\Company\Models\CompanyAccount;
use SimpleCMS\Company\Abstracts\CompanyAbstract;
use SimpleCMS\Company\Listeners\ApiLoginListener;
use SimpleCMS\Company\Listeners\LoginFailedListener;
use SimpleCMS\Company\Listeners\LoginSuccessListener;
use SimpleCMS\Company\Listeners\CompanyRequestListener;
use SimpleCMS\Company\Http\Middleware\CompanyLogMiddleware;

class CompanyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerEvents();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->bootConfig();
        $this->loadFacades();
        $this->bindListeners();
        $this->bindCompanyRelationships();
        $this->bindObservers();
    }

    /**
     * 加载模型事件
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return void
     */
    protected function bindObservers(): void
    {
        Company::observe(\SimpleCMS\Company\Observers\CompanyObserver::class);
        CompanyAccount::observe(\SimpleCMS\Company\Observers\CompanyAccountObserver::class);
    }

    /**
     * 动态绑定 Company 模型的关系
     */
    protected function bindCompanyRelationships(): void
    {
        $modelsPath = app_path('Models');
        $namespace = 'App\\Models\\';

        // 获取所有模型文件
        $modelFiles = File::allFiles($modelsPath);

        foreach ($modelFiles as $file) {
            $modelClass = $namespace . $file->getFilenameWithoutExtension();

            // 检查模型是否继承了 CompanyAbstract
            if (is_subclass_of($modelClass, CompanyAbstract::class)) {
                $relationName = Str::plural(Str::camel(class_basename($modelClass)));

                // 动态添加 hasMany 关系
                Company::resolveRelationUsing($relationName, function (Company $company) use ($modelClass) {
                    return $company->hasMany($modelClass);
                });
            }
        }
    }

    /**
     * 注册事件
     */
    protected function registerEvents(): void
    {
        $this->app->bind('simplecms.plugin.company.api_login', function (CompanyAccount $account) {
            return new ApiLogin($account);
        });
        $this->app->bind('simplecms.plugin.company.login_failed', function (CompanyAccount $account) {
            return new LoginFailed($account);
        });
        $this->app->bind('simplecms.plugin.company.login_success', function (CompanyAccount $account) {
            return new LoginSuccess($account);
        });
        $this->app->bind('simplecms.plugin.company.company_request', function (Request $request, bool $status) {
            return new CompanyRequest($request, $status);
        });
    }

    /**
     * 绑定监听器
     */
    protected function bindListeners(): void
    {
        Event::listen(ApiLogin::class, [ApiLoginListener::class, 'handle']);
        Event::listen(LoginFailed::class, [LoginFailedListener::class, 'handle']);
        Event::listen(LoginSuccess::class, [LoginSuccessListener::class, 'handle']);
        Event::listen(CompanyRequest::class, [CompanyRequestListener::class, 'handle']);
    }

    /**
     * 绑定 Facades
     */
    protected function loadFacades(): void
    {
        $this->app->bind('company_authenticatable', fn() => new \SimpleCMS\Company\Packages\CompanyAuthenticatable);
    }

    /**
     * 初始化配置文件
     */
    protected function bootConfig(): void
    {
        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
            __DIR__ . '/../database/seeders' => database_path('seeders'),
        ], 'simplecms');
    }


    /**
     * 注册Middleware
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return void
     */
    protected function registerMiddleware(): void
    {
        $this->app->singleton(CompanyLogMiddleware::class);
    }
}
