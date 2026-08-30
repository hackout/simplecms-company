<?php
namespace SimpleCMS\Company\Packages;

class CompanyUtil
{
    /**
     * 生成UID
     * @return string<class-string>
     */
    public static function makeNewUid(string $model): string
    {
        $maxUid = $model::max('uid') ?: 1000;
        return bcadd($maxUid, rand(1, 20), 0);
    }
}