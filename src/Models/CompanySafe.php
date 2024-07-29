<?php

namespace SimpleCMS\Company\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * CompanySafe Model
 * @author Dennis Lui <hackout@vip.qq.com>
 *
 * @property string $id 主键
 * @property string $company_account_id 账号ID
 * @property string $type 类型
 * @property string $account 登录账号
 * @property ?string $code 名称
 * @property bool $is_verified 权限
 * @property ?Carbon $verified_at 密码
 * @property ?Carbon $valid_at 是否可用
 * @property ?string $verified_ip 是否管理员
 * @property ?string $verified_finger 最后登录时间
 * @property-read ?Carbon $created_at 创建时间
 * @property-read ?Carbon $updated_at 更新时间
 * @property-read ?CompanyAccount $account 登录账号
 */
class CompanySafe extends Model
{
    use HasFactory;

    /**
     * 可输入字段
     */
    protected $fillable = [
        'id',
        'company_account_id',
        'type',
        'account',
        'code',
        'is_verified',
        'verified_at',
        'valid_at',
        'verified_ip',
        'verified_finger',
    ];
    /**
     * 显示字段类型
     */
    public $casts = [
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
        'valid_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * 追加字段
     */
    public $appends = [];

    /**
     * 隐藏关系
     */
    public $hidden = [];

    public function account()
    {
        return $this->belongsTo(CompanyAccount::class);
    }

}
