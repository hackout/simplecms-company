<?php
namespace SimpleCMS\Company\Enums;

enum CompanyApplyStatusEnum: int
{
    /**
     * 待提交
     */
    case Pending = 0;

    /**
     * 审核中
     */
    case Reviewing = 1;

    /**
     * 审核通过
     */
    case Pass = 2;

    /**
     * 审核拒绝
     */
    case Reject = 3;

    /**
     * 关闭
     */
    case Close = 4;

    public static function fromValue(int $type): self
    {
        return match ($type) {
            1 => self::Reviewing,
            2 => self::Pass,
            3 => self::Reject,
            4 => self::Close,
            default => self::Pending
        };
    }

    public function canClose(): bool
    {
        return match ($this) {
            self::Reviewing => true,
            self::Pending => true,
            default => false
        };
    }
    public function canDelete(): bool
    {
        return match ($this) {
            self::Reject => true,
            self::Close => true,
            self::Pending => true,
            default => false
        };
    }

    public function canSubmit(): bool
    {
        return match ($this) {
            self::Pending => true,
            default => false
        };
    }

    public function isPass(): bool
    {
        return $this === self::Pass;
    }

    public function isReject(): bool
    {
        return $this === self::Reject;
    }

    public function isReviewing(): bool
    {
        return $this === self::Reviewing;
    }
}