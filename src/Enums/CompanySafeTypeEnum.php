<?php
namespace SimpleCMS\Company\Enums;

enum CompanySafeTypeEnum: string
{
    /**
     * 手机号码
     */
    case Mobile = 'mobile';

    /**
     * 邮箱
     */
    case Email = 'email';


    public static function fromValue(int $type): self
    {
        return match ($type) {
            'email' => self::Email,
            default => self::Mobile
        };
    }

}