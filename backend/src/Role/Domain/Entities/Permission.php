<?php

namespace Src\Role\Domain\Entities;

interface Permission
{
    public function getId(): int;
    public function getName(): string;
}
