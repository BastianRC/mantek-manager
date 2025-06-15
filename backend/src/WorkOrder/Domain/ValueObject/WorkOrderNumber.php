<?php

namespace Src\WorkOrder\Domain\ValueObject;

use InvalidArgumentException;

class WorkOrderNumber
{
    private const TEMPORARY = 'WO-TEMP';
    private string $value;

    public function __construct(string $value, bool $skipValidation = false)
    {
        if (!$skipValidation && !$this->isValid($value)) {
            throw new InvalidArgumentException("Invalid work order number format: $value");
        }

        $this->value = $value;
    }

    public static function fromId(int $id): self
    {
        $year = date('y');
        $number = str_pad($id, 4, '0', STR_PAD_LEFT);
        return new self("WO-{$year}{$number}");
    }

    public static function temp(): self
    {
        return new self(self::TEMPORARY, true);
    }

    private function isValid(string $value): bool
    {
        return preg_match('/^WO-\d{6}$/', $value) === 1;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value();
    }

    public function isTemporary(): bool
    {
        return $this->value === self::TEMPORARY;
    }
}
