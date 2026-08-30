<?php

namespace SimpleCMS\Company\Traits;

use SimpleCMS\Company\Models\Company;

/**
 * 动态单元Trait
 *
 * @author Dennis Lui <hackout@vip.qq.com>
 *
 * 使用:
 * 
 *   use \SimpleCMS\Company\Traits\CompanyTrait;
 *
 * @use \Illuminate\Database\Eloquent\Model
 * @use \Illuminate\Database\Eloquent\Concerns\HasRelationships
 *
 */
trait CompanyTrait
{

    /**
     * 企业公司
     * @return mixed
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

}
