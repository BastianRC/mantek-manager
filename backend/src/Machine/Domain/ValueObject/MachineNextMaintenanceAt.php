<?php

namespace Src\Machine\Domain\ValueObject;

use Src\Shared\Domain\ValueObjects\BaseDateTime;

class MachineNextMaintenanceAt extends BaseDateTime
{
    public function toString(string $format = 'Y-m-d'): string
    {
        return $this->value->format($format);
    }
}
