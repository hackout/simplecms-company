<?php
namespace SimpleCMS\Company\Enums;

enum CompanyStatusEnum: int
{
    /**
     * 营业中
     */
    case Opening = 0;

    /**
     * 歇业
     */
    case Closure = 1;

    /**
     * 闭业
     */
    case Close = 2;

    /**
     * 清退
     */
    case Out = 3;

    public static function fromValue(int $type): self
    {
        return match ($type) {
            1 => self::Closure,
            2 => self::Close,
            3 => self::Out,
            default => self::Opening
        };
    }

    public function canTrade(): bool
    {
        return match ($this) {
            self::Opening => true,
            self::Closure => true,
            default => false
        };
    }

    public function isOpening(): bool
    {
        return $this === self::Opening;
    }

    public function isClosure(): bool
    {
        return $this === self::Closure;
    }

    public function isClose(): bool
    {
        return $this === self::Close;
    }
}