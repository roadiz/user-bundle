<?php

declare(strict_types=1);

namespace RZ\Roadiz\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class RoadizUserBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
