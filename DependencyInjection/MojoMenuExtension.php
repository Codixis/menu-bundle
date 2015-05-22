<?php

namespace Mojo\Bundle\MenuBundle\DependencyInjection;

use Sonata\EasyExtendsBundle\Mapper\DoctrineCollector;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class MojoMenuExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('admin.xml');
        $loader->load('form_types.xml');
        $loader->load('core.xml');

        $this->configureAvaiableRoutes($config['avaiable_routes'], $container);
        $this->configureEntity($config['class'], $container);
        $this->configureAdmin($config['admin'], $container);
        $this->configureDoctrineMapping($config['class'], $container);
    }

    protected function configureAvaiableRoutes(array $config, ContainerBuilder $container)
    {
        $definitionMenu = $container->getDefinition('menu.admin.menu');
        $definitionMenu->addMethodCall('setAvaiableRoutes', array($config));

        $definitionMenuItem = $container->getDefinition('menu.admin.menuitem');
        $definitionMenuItem->addMethodCall('setAvaiableRoutes', array($config));
    }

    protected function configureEntity(array $config, ContainerBuilder $container)
    {
        $container->setParameter('mojo.menu.entity.menu', $config['menu']);
        $container->setParameter('mojo.menu.entity.menuitem', $config['menuitem']);
    }

    protected function configureAdmin(array $config, ContainerBuilder $container)
    {
        foreach ($config as $name => $values) {
            $container->setParameter("mojo.menu.admin.$name.class", $values['class']);
            $container->setParameter("mojo.menu.admin.$name.controller", $values['controller']);
            $container->setParameter("mojo.menu.admin.$name.translation_domain", $values['translation_domain']);
        }
    }

    /**
     * @param array $config
     */
    protected function configureDoctrineMapping(array $config)
    {
        $collector = DoctrineCollector::getInstance();

        $this->registerMenuItem($collector, $config);
        $this->registerChildren($collector, $config);
    }

    protected function registerMenuItem(DoctrineCollector $collector, $config)
    {
        $collector->addAssociation($config['menu'], 'mapOneToMany', array(
            'fieldName' => 'items',
            'targetEntity' => $config['menuitem'],
            'cascade' => array(
                1 => 'persist',
            ),
            'mappedBy' => 'menu',
            'orphanRemoval' => true,
            'orderBy' => array(
                'position' => 'ASC',
            ),
        ));

        $collector->addAssociation($config['menuitem'], 'mapManyToOne', array(
            'fieldName' => 'menu',
            'targetEntity' => $config['menu'],
            'cascade' => array(
                1 => 'persist',
            ),
            'mappedBy' => null,
            'inversedBy' => 'items',
            'joinColumns' => array(
                array(
                    'name' => 'menu_id',
                    'referencedColumnName' => 'id',
                    'nullable' => true,
                ),
            ),
            'orphanRemoval' => false,
        ));
    }

    protected function registerChildren(DoctrineCollector $collector, $config)
    {
        $collector->addAssociation($config['menuitem'], 'mapOneToMany', array(
            'fieldName' => 'children',
            'targetEntity' => $config['menuitem'],
            'cascade' => array(
                1 => 'persist',
            ),
            'mappedBy' => 'parent',
            'orphanRemoval' => true,
            'orderBy' => array(
                'position' => 'ASC',
            ),
        ));

        $collector->addAssociation($config['menuitem'], 'mapManyToOne', array(
            'fieldName' => 'parent',
            'targetEntity' => $config['menuitem'],
            'cascade' => array(
                1 => 'persist',
            ),
            'mappedBy' => null,
            'inversedBy' => 'children',
            'joinColumns' => array(
                array(
                    'name' => 'parent_id',
                    'referencedColumnName' => 'id',
                    'nullable' => true,
                ),
            ),
            'orphanRemoval' => false,
        ));
    }
}
