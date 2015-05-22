<?php

namespace Mojo\Bundle\MenuBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Mojo\Bundle\MenuBundle\Model\Menu;

/**
 * BaseMenu.
 */
abstract class BaseMenu extends Menu
{
    public function __construct()
    {
        $this->setItems(new ArrayCollection());
    }

    abstract public function getId();

    abstract public function setId($id);
}
