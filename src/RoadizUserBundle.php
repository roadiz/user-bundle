<?php

declare(strict_types=1);

namespace RZ\Roadiz\UserBundle;

use RZ\Roadiz\UserBundle\DependencyInjection\Compiler\DoctrineMigrationCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class RoadizUserBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new DoctrineMigrationCompilerPass());
    }
}
