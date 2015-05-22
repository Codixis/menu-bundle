<?php

namespace Mojo\Bundle\MenuBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

abstract class Menu implements MenuInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var ArrayCollection
     */
    protected $items;

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

    /**
     * @inheritdoc
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @inheritdoc
     */
    public function setItems(ArrayCollection $items)
    {
        $this->items = $items;

        return $this;
    }

    public function addItem(MenuItemInterface $item)
    {
        $item->setMenu($this);
        $this->items[] = $item;

        return $this;
    }

    public function getChildren()
    {
        return array_filter($this->items->toArray(), function ($item) {
            return is_null($item->getParent());
        });
    }

    public function __toString()
    {
        $name = $this->getName();

        return $name ? $name : 'n/a';
    }
}
