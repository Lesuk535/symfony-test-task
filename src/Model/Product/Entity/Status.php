<?php

declare(strict_types=1);

namespace App\Model\Product\Entity;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

class Status
{
    public const STATUS_UNAVAILABLE = 'unavailable';
    public const STATUS_AVAILABLE = 'available';
    public const STATUS_INACTIVE = 'inactive';

    /**
     * @ORM\Column(type="string", length=16)
     */
    private string $status;

    public function __construct(string $status)
    {
        Assert::oneOf($status, [
            self::STATUS_UNAVAILABLE,
            self::STATUS_AVAILABLE,
            self::STATUS_INACTIVE,
        ]);
        $this->status = $status;
    }

    public static function inactive(): self
    {
        return new self(self::STATUS_INACTIVE);
    }

    public static function unavailable(): self
    {
        return new self(self::STATUS_UNAVAILABLE);
    }

    public static function available(): self
    {
        return new self(self::STATUS_AVAILABLE);
    }

    public function isUnavailable(): bool
    {
        return $this->status === self::STATUS_UNAVAILABLE;
    }

    public function isAvailable(): bool
    {
        return $this->status === self::STATUS_AVAILABLE;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function __toString(): string
    {
        return $this->getStatus();
    }
}