<?php

declare(strict_types=1);

namespace RZ\Roadiz\UserBundle\Api\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final class UserInput
{
    public string $email = '';
    public string $plainPassword = '';
    public ?string $firstName = null;
    public ?string $lastName = null;
}
