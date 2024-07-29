<?php

namespace SimpleCMS\Company\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use SimpleCMS\Framework\Contracts\SimpleMedia;
use Illuminate\Database\Eloquent\Relations\HasMany;
use SimpleCMS\Framework\Traits\MediaAttributeTrait;
use SimpleCMS\Framework\Traits\PrimaryKeyUuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Company Model
 * @author Dennis Lui <hackout@vip.qq.com>
 *
 * @property string $id 主键
 * @property string $company_apply_id 注册申请表ID
 * @property string $name 名称
 * @property string $uid 暴露UID
 * @property int $status 状态
 * @property string $type 资料类型
 * @property bool $is_valid 是否有效
 * @property ?string $introduction 介绍说明
 * @property int $level 账户等级
 * @property ?string $business 商务信息
 * @property ?string $remark 备注
 * @property ?Carbon $success_at 通过时间
 * @property ?Carbon $reject_at 拒绝时间
 * @property-read ?Carbon $created_at 创建时间
 * @property-read ?Carbon $updated_at 更新时间
 * @property-read ?Collection<CompanyAccount> $accounts 登录账号
 * @property-read ?Collection<CompanyLog> $logs 请求日志
 * @property-read ?CompanyProfile $profile 子项
 * @property-read ?CompanyApply $apply 子项
 * @property-read ?Collection<Media> $media 附件
 * @property-read ?array<string<"name","url","uuid">,string> $logo Logo
 */
class Company extends Model implements SimpleMedia
{
    use HasFactory, PrimaryKeyUuidTrait, MediaAttributeTrait;

    /**
     * Logo
     */
    const MEDIA_LOGO = 'logo';

    const HAS_ONE_MEDIA = ['logo'];

    /**
     * 可输入字段
     */
    protected $fillable = [
        'id',
        'company_apply_id',
        'name',
        'uid',
        'status',
        'type',
        'is_valid',
        'introduction',
        'level',
        'business',
        'remark',
        'success_at',
        'reject_at',
    ];

    /**
     * 显示字段类型
     */
    public $casts = [
        'status' => 'integer',
        'level' => 'integer',
        'is_valid' => 'boolean',
        'success_at' => 'datetime',
        'reject_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * 追加字段
     */
    public $appends = ['logo'];

    /**
     * 隐藏关系
     */
    public $hidden = ['media'];

    public function getLogoAttribute()
    {
        if (!$media = $this->getFirstMedia(self::MEDIA_LOGO))
            return [];
        return [
            'name' => $media->file_name,
            'url' => $media->original_url,
            'uuid' => $media->uuid
        ];
    }

    /**
     * 登录账号
     * @return HasMany
     */
    public function accounts()
    {
        return $this->hasMany(CompanyAccount::class);
    }

    /**
     * 企业资料
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile()
    {
        return $this->hasOne(CompanyProfile::class);
    }

    /**
     * 申请记录
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function apply()
    {
        return $this->belongsTo(CompanyApply::class);
    }

    /**
     * 操作日志
     * @return HasMany
     */
    public function logs()
    {
        return $this->hasMany(CompanyLog::class);
    }
}
