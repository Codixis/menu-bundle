<?php

namespace Mojo\Bundle\MenuBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

abstract class MenuItem implements MenuItemInterface
{
    /**
     * @var MenuInterface
     */
    protected $menu;

    /**
     * @var MenuItemInterface
     */
    protected $parent;

    /**
     * @var ArrayCollection
     */
    protected $children;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $routeKey;

    /**
     * @var string
     */
    protected $routeName;

    /**
     * @var array
     */
    protected $params;

    /**
     * @var int
     */
    protected $position;

    /**
     * @inheritdoc
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * @inheritdoc
     */
    public function setMenu(MenuInterface $menu)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @inheritdoc
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @inheritdoc
     */
    public function setChildren(ArrayCollection $children)
    {
        $this->children = $children;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
    }

    public function getRouteKey()
    {
        return $this->routeKey;
    }

    public function setRouteKey($routeKey)
    {
        $this->routeKey = $routeKey;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setRouteName($routeName)
    {
        $this->routeName = $routeName;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getRouteName()
    {
        return $this->routeName;
    }

    /**
     * @inheritdoc
     */
    public function setParams($params)
    {
        $this->params = $params;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @inheritdoc
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @inheritdoc
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }
}
