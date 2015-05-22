<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Mojo\Bundle\MenuBundle\Menu;

use Knp\Menu\FactoryInterface;
use Mojo\Bundle\MenuBundle\Model\MenuInterface;

/**
 * Description of Builder.
 *
 * @author pato
 */
class MenuBuilder
{
    private $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMenu(MenuInterface $menu = null)
    {
        $knpMenu = $this->factory->createItem('root');

        if ($menu) {
            foreach ($menu->getChildren() as $item) {
                $this->addMenu($knpMenu, $item);
            }
        }

        return $knpMenu;
    }

    private function addMenu($root, $item)
    {
        //$name = $item->getName();
        $name = $item->getName();
        $route = $item->getRoutename();
        $params = $item->getParams();

        $node = $root->addChild($name, array(
            'route' => $route,
            'routeParameters' => $params,
        ));
        foreach ($item->getChildren() as $subItem) {
            $this->addMenu($node, $subItem);
        }
    }
}
