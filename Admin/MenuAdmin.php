<?php

namespace Mojo\Bundle\MenuBundle\Admin;

use Mojo\Bundle\MenuBundle\Model\MenuItem;
use Mojo\Bundle\MenuBundle\Model\MenuItemInterface;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;

class MenuAdmin extends Admin
{
    /**
     * @var array
     */
    private $avaiableRoutes = array();

    /**
     * @var string
     */
    private $itemClass;

    public function setMenuItemClass($itemClass)
    {
        $this->itemClass = $itemClass;

        return $this;
    }

    public function setAvaiableRoutes(array $routes)
    {
        $this->avaiableRoutes = $routes;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->addIdentifier('name')
                ->add('site')
        ;
    }

    public function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                ->add('name')
                ->add('site')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->with('General', array('class' => 'col-md-4'))
                ->add('name')
                ->add('site', 'sonata_type_model_list', array(
                    'btn_add' => false,
                    'btn_delete' => false,
                    'required' => true, ), array(
                    'link_parameters' => array(
                        'selector' => 'site',
                    ),
                        )
                )
                ->end();

        if ($this->hasSubject() and $this->getSubject()->getSite()) {
            $formMapper->with('Items', array('class' => 'col-md-8'))
                    ->add('items', 'mojo_type_tree_collection', array(
                            ), array(
                        'edit' => 'inline',
                        'inline' => 'table',
                        'link_parameters' => array(
                            'site' => $this->getSubject()->getSite()->getId(),
                        ),
                    ))
                    ->end();
        }
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement
                ->with('name')
                ->assertNotBlank()
                ->end()
                ->with('site')
                ->assertNotBlank()
                ->end()
        ;
    }

    public function prePersist($menu)
    {
        foreach ($menu->getItems() as $item) {
            $item->setMenu($menu);
            $parent = $this->prepare($item);
            $item->setParent($parent);
        }
    }

    public function preUpdate($menu)
    {
        foreach ($menu->getItems() as $key => $item) {
            $item->setMenu($menu);

            if ($this->prepareItem($item)) {
                $parent = $this->prepare($item);
                $item->setParent($parent);
            } else {
                $menu->getItems()->remove($key);
            }
        }
    }

    private function prepareItem(MenuItem $item)
    {
        $key = $item->getRouteKey();
        $name = $item->getName();
        $position = $item->getPosition();

        if (empty($name)) {
            if (empty($key)) {
                return false;
            }

            $item->setName($key);
        }

        if (empty($position)) {
            $item->setPosition(0);
        }

        if (isset($this->avaiableRoutes[$key])) {
            $config = $this->avaiableRoutes[$key];
            $routeName = $config['route'];
            $params = (array) $config['params'];

            $item->setRouteName($routeName);
            $item->setParams($params);
        }

        return true;
    }

    private function prepare(MenuItem $item)
    {
        $parent = null;
        if ($item->getParent() instanceof MenuItemInterface) {
            if ($item->getParent()->getId()) {
                $parent = $item->getParent();
            }
        } else {
            $parent = $this->getModelManager()->find($this->itemClass, $item->getParent());
        }

        return $parent;
    }
}
