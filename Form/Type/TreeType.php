<?php

namespace Mojo\Bundle\MenuBundle\Form\Type;

use Symfony\Component\Form\AbstractType;

class TreeType extends AbstractType {

    /**
     * {@inheritDoc}
     */
    public function getParent() {
        return 'sonata_type_collection';
    }

    /**
     * {@inheritDoc}
     */
    public function getName() {
        return 'mojo_type_tree_collection';
    }

}
