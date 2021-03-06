<?php

namespace Trappar\AliceGeneratorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder()
    {
        $tb = new TreeBuilder('trappar_alice_generator');

        if (method_exists($tb, 'getRootNode')) {
            $root = $tb->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $root = $tb->root('trappar_alice_generator');
        }

        $root->children()
            ->arrayNode('metadata')
                ->addDefaultsIfNotSet()
                ->fixXmlConfig('directory', 'directories')
                ->children()
                    ->booleanNode('auto_detection')->defaultTrue()->end()
                    ->arrayNode('directories')
                        ->prototype('array')
                            ->children()
                                ->scalarNode('path')->isRequired()->end()
                                ->scalarNode('namespace_prefix')->defaultValue('')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
            ->arrayNode('yaml')
                ->addDefaultsIfNotSet()
                ->children()
                    ->integerNode('inline')->defaultValue(3)->end()
                    ->integerNode('indent')->defaultValue(4)->end()
                ->end()
            ->end()
            ->booleanNode('strictTypeChecking')->defaultValue(true)->end()
        ->end();

        return $tb;
    }
}