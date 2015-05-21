<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Mojo\Bundle\MenuBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 *
 * @author pato
 */
interface MenuInterface {

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Menu
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * get items
     * 
     * @return ArrayCollection
     */
    public function getItems();

    /**
     * set items
     * 
     * @param ArrayCollection $items
     * @return MenuInterface
     */
    public function setItems(ArrayCollection $items);
}
