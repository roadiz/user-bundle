<?php

declare(strict_types=1);

namespace RZ\Roadiz\UserBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $builder = new TreeBuilder('roadiz_user');
        $root = $builder->getRootNode();
        $root->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('password_reset_url')
                ->info(<<<EOT
Define frontend URL to redirect user to after receiving its password recovery email.
**This parameter supports Symfony routes name as well as hard-coded URLs.**
EOT)
            ->end()
            ->integerNode('password_reset_expires_in')
                ->defaultValue(600)
                ->info(<<<EOT
Define password recovery expiring time in seconds.
EOT)
            ->end()
        ;
        return $builder;
    }
}
