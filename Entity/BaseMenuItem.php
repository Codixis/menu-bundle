<?php

namespace Mojo\Bundle\MenuBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Mojo\Bundle\MenuBundle\Model\MenuItem;

/**
 * BaseMenuItem
 */
abstract class BaseMenuItem extends MenuItem {

    public function __construct() {
        $this->setChildren(new ArrayCollection());
        $this->setParams(array());
    }

    abstract public function getId();

    abstract public function setId($id);
}
