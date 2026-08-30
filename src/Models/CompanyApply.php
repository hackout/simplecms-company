<?php

namespace SimpleCMS\Company\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use SimpleCMS\Framework\Contracts\SimpleMedia;
use SimpleCMS\Framework\Traits\MediaAttributeTrait;
use SimpleCMS\Framework\Traits\PrimaryKeyUuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Banner Model
 * @author Dennis Lui <hackout@vip.qq.com>
 *
 * @property string $id 主键
 * @property string<"company","person"> $type 资料类型
 * @property string $id_number 企业注册号/身份证号码
 * @property string $name 企业名称
 * @property string $legal 法人/注册人
 * @property ?string $phone 联系电话
 * @property ?string $email 联系邮箱
 * @property ?string $address 注册地址
 * @property ?string $account 登录账号
 * @property ?string $password 登录密码
 * @property int $status 申请状态
 * @property ?string $reason 申请理由
 * @property ?string $remark 备注
 * @property ?string $reject 拒绝理由
 * @property ?Carbon $success_at 通过时间
 * @property ?Carbon $reject_at 拒绝时间
 * @property-read ?Carbon $created_at 创建时间
 * @property-read ?Carbon $updated_at 更新时间
 * @property-read ?Company $company 审核通过后的公司信息
 * @property-read ?Collection<Media> $media 附件
 * @property-read ?array<array<string,string>> $files 辅助资料
 * @property-read ?array<string,string> $logo Logo
 * @property-read ?array<string,string> $front 证件正面
 * @property-read ?array<string,string> $back 证件反面
 */
class CompanyApply extends Model implements SimpleMedia
{
    use HasFactory, PrimaryKeyUuidTrait, MediaAttributeTrait;

    /**
     * Media Key
     */
    const MEDIA_FILE = 'file';

    /**
     * Logo
     */
    const MEDIA_LOGO = 'logo';

    /**
     * 证件正面
     * @var string
     */
    const MEDIA_FRONT = 'front';

    /**
     * 证件背面
     * @var string
     */
    const MEDIA_BACK = 'back';

    const HAS_ONE_MEDIA = ['logo', 'front', 'back'];

    /**
     * 可输入字段
     */
    protected $fillable = [
        'id',
        'type',
        'id_number',
        'name',
        'legal',
        'phone',
        'email',
        'address',
        'account',
        'password',
        'status',
        'reason',
        'remark',
        'reject',
        'success_at',
        'reject_at',
    ];

    /**
     * 显示字段类型
     */
    public $casts = [
        'status' => 'integer',
        'success_at' => 'datetime',
        'reject_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * 追加字段
     */
    public $appends = ['logo', 'front', 'back', 'files'];

    /**
     * 隐藏关系
     */
    public $hidden = ['media', 'password'];


    public function getFilesAttribute()
    {
        if (!$medias = $this->getMedia(self::MEDIA_FILE))
            return [];
        return $medias->map(function ($item) {
            return [
                'name' => $item->file_name,
                'url' => $item->original_url,
                'uuid' => $item->uuid
            ];
        });
    }

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

    public function getBackAttribute()
    {
        if (!$media = $this->getFirstMedia(self::MEDIA_BACK))
            return [];
        return [
            'name' => $media->file_name,
            'url' => $media->original_url,
            'uuid' => $media->uuid
        ];
    }

    public function getFrontAttribute()
    {
        if (!$media = $this->getFirstMedia(self::MEDIA_FRONT))
            return [];
        return [
            'name' => $media->file_name,
            'url' => $media->original_url,
            'uuid' => $media->uuid
        ];
    }

    /**
     * 申请通过后的公司信息
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function company()
    {
        return $this->hasOne(Company::class);
    }
}
