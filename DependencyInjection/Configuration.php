<?php

namespace Mojo\Bundle\MenuBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface {

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder() {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('mojo_menu');

        $rootNode
                ->children()
                    ->arrayNode('avaiable_routes')
                        ->prototype('array')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('route')->end()
                                ->arrayNode('params')
                                    ->prototype('scalar')
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()                
                    ->arrayNode('class')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('menu')->defaultValue('AppBundle\\Entity\\Menu')->end()
                            ->scalarNode('menuitem')->defaultValue('AppBundle\\Entity\\MenuItem')->end()
                        ->end()
                    ->end()
                    ->arrayNode('admin')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->arrayNode('menu')
                                ->addDefaultsIfNotSet()
                                ->children()
                                    ->scalarNode('class')->defaultValue('Mojo\\Bundle\\MenuBundle\\Admin\\MenuAdmin')->end()
                                    ->scalarNode('controller')->defaultValue('SonataAdminBundle:CRUD')->end()
                                    ->scalarNode('translation_domain')->defaultValue('MojoMenuBundle')->end()                
                                ->end()
                            ->end()
                            ->arrayNode('menuitem')
                                ->addDefaultsIfNotSet()
                                ->children()
                                    ->scalarNode('class')->defaultValue('Mojo\\Bundle\\MenuBundle\\Admin\\MenuItemAdmin')->end()
                                    ->scalarNode('controller')->defaultValue('SonataAdminBundle:CRUD')->end()
                                    ->scalarNode('translation_domain')->defaultValue('MojoMenuBundle')->end()                
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end();

        return $treeBuilder;
    }

}
