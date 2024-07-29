<?php

namespace SimpleCMS\Company\Models;

use Carbon\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Collection;
use SimpleCMS\Framework\Contracts\SimpleMedia;
use SimpleCMS\Framework\Traits\MediaAttributeTrait;
use SimpleCMS\Framework\Traits\PrimaryKeyUuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Company Model
 * @author Dennis Lui <hackout@vip.qq.com>
 *
 * @property string $id 主键
 * @property string $company_id 企业ID
 * @property string $uid 暴露UID
 * @property string $account 登录账号
 * @property string $name 名称
 * @property ?array $roles 权限
 * @property string $password 密码
 * @property bool $is_valid 是否可用
 * @property bool $is_founder 是否管理员
 * @property ?Carbon $last_login 最后登录时间
 * @property ?string $last_ip 最后登录IP
 * @property ?string $register_ip 注册IP
 * @property ?string $register_finger 设备指纹
 * @property int $failed_count 失败次数
 * @property-read ?Carbon $created_at 创建时间
 * @property-read ?Carbon $updated_at 更新时间
 * @property-read ?Collection<CompanySafe> $safes 安全信息
 * @property-read ?Collection<CompanyLog> $logs 请求日志
 * @property-read ?Company $company 企业
 * @property-read ?Collection<Media> $media 附件
 * @property-read ?array<string<"name","url","uuid">,string> $avatar 头像
 */
class CompanyAccount extends Authenticatable implements SimpleMedia
{
    use HasFactory, PrimaryKeyUuidTrait, MediaAttributeTrait, HasApiTokens;
    /**
     * Avatar
     */
    const MEDIA_AVATAR = 'avatar';

    const HAS_ONE_MEDIA = ['avatar'];

    /**
     * 可输入字段
     */
    protected $fillable = [
        'id',
        'company_id',
        'uid',
        'account',
        'name',
        'roles',
        'password',
        'is_valid',
        'is_founder',
        'last_login',
        'last_ip',
        'register_ip',
        'register_finger',
        'failed_count'
    ];
    /**
     * 显示字段类型
     */
    public $casts = [
        'roles' => 'array',
        'is_valid' => 'boolean',
        'is_founder' => 'boolean',
        'success_at' => 'datetime',
        'reject_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * 追加字段
     */
    public $appends = ['avatar'];

    /**
     * 隐藏关系
     */
    public $hidden = ['media'];

    public function getAvatarAttribute()
    {
        if (!$media = $this->getFirstMedia(self::MEDIA_AVATAR))
            return [];
        return [
            'name' => $media->file_name,
            'url' => $media->original_url,
            'uuid' => $media->uuid
        ];
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function logs()
    {
        return $this->hasMany(CompanyLog::class);
    }

    public function safes()
    {
        return $this->hasMany(CompanySafe::class);
    }
}
