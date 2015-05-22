<?php

namespace Mojo\Bundle\MenuBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

interface MenuItemInterface
{
    /**
     * get menu.
     *
     * @return MenuInterface
     */
    public function getMenu();

    /**
     * set menu.
     *
     * @param MenuInterface $menu
     *
     * @return MenuItemInterface
     */
    public function setMenu(MenuInterface $menu);

    /**
     * get parent.
     *
     * @return MenuInterface
     */
    public function getParent();

    /**
     * set parent.
     *
     * @param MenuItemInterface $parent
     *
     * @return MenuItemInterface
     */
    public function setParent($parent);

    /**
     * get children.
     *
     * @return ArrayCollection
     */
    public function getChildren();

    /**
     * set children.
     *
     * @param ArrayCollection $children
     *
     * @return MenuItemInterface
     */
    public function setChildren(ArrayCollection $children);

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return MenuItem
     */
    public function setName($name);

    /**
     * Get name.
     *
     * @return string
     */
    public function getName();

    /**
     * Set routeName.
     *
     * @param string $routeName
     *
     * @return MenuItem
     */
    public function setRouteName($routeName);

    /**
     * Get routeName.
     *
     * @return string
     */
    public function getRouteName();
    /**
     * Set route.
     *
     * @param string $route
     *
     * @return MenuItem
     */
    public function setRouteKey($routeKey);

    /**
     * Get route.
     *
     * @return string
     */
    public function getRouteKey();

    /**
     * Set params.
     *
     * @param array $params
     *
     * @return MenuItemInterface
     */
    public function setParams($params);

    /**
     * Get params.
     *
     * @return array
     */
    public function getParams();

    /**
     * Get position.
     *
     * @return int
     */
    public function getPosition();

    /**
     * Set position.
     *
     * @param int $position
     *
     * @return MenuItemInterface
     */
    public function setPosition($position);
}
