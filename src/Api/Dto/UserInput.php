<?php

declare(strict_types=1);

namespace RZ\Roadiz\UserBundle\Api\Dto;

final class UserInput
{
    public string $email;
    public string $clearPassword;
    public ?string $firstName;
    public ?string $lastName;
}
