<?php
namespace SimpleCMS\Company\Enums;

enum CompanyTypeEnum: string
{
    /**
     * 企业
     */
    case Company = 'company';

    /**
     * 个人
     */
    case Person = 'person';


    public static function fromValue(int $type): self
    {
        return match ($type) {
            'person' => self::Person,
            default => self::Company
        };
    }

}