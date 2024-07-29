<?php
namespace SimpleCMS\Company\Packages;

class CompanyUtil
{
    /**
     * 生成UID
     * @return class-string
     */
    public static function makeNewUid(string $model): string
    {
        $maxUid = $model::max('uid') ?: 1000;
        return bcadd($maxUid, rand(1, 20), 0);
    }
}