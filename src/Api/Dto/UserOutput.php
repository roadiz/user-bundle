<?php

declare(strict_types=1);

namespace RZ\Roadiz\UserBundle\Api\Dto;

final class UserOutput
{
    public string $identifier = '';
    public array $roles = [];
    public bool $emailValidated = false;
}
