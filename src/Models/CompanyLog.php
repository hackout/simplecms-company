<?php

namespace SimpleCMS\Company\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use SimpleCMS\Framework\Traits\PrimaryKeyUuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * 请求日志
 *
 * @author Dennis Lui <hackout@vip.qq.com>
 * @property string $id 主键
 * @property ?string $company_id 企业ID
 * @property ?string $company_account_id 账号ID
 * @property ?string $name 说明
 * @property ?string $ip_address IP
 * @property ?array $user_agent UserAgent
 * @property string $method 请求方法
 * @property string $url 请求地址
 * @property ?array $parameters 请求参数
 * @property string $route_name 路由别名
 * @property bool $status 请求状态
 * @property-read Carbon $created_at 发生时间
 * @property-read ?Company $company 企业
 * @property-read ?CompanyAccount $account 账号
 */
class CompanyLog extends Model
{
    use HasFactory, PrimaryKeyUuidTrait;

    /**
     * 删除更新时间
     */
    const UPDATED_AT = null;

    /**
     * 可输入字段
     */
    protected $fillable = [
        'id',
        'company_id',
        'company_account_id',
        'name',
        'ip_address',
        'user_agent',
        'method',
        'url',
        'parameters',
        'route_name',
        'status'
    ];

    /**
     * 显示字段类型
     */
    public $casts = [
        'user_agent' => 'array',
        'parameters' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'status' => 'boolean'
    ];

    /**
     * 隐藏关系
     */
    public $hidden = [];

    /**
     * 企业
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * 操作账号
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(CompanyAccount::class);
    }
}
