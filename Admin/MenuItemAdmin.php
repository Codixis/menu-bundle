<?php

namespace Mojo\Bundle\MenuBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\PageBundle\Entity\PageManager;

class MenuItemAdmin extends Admin
{

    /**
     * @var array
     */
    private $avaiableRoutes = array();

    /**
     * @var PageManager
     */
    private $pageManager;

    public function setAvaiableRoutes(array $routes)
    {
        $this->avaiableRoutes = $routes;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('name', null, array('required' => true))
                ->add('type', 'choice', array('required' => true, 'choices' => array(
                        'url' => 'url',
                        'section' => 'sección'
            )))
                ->add('uri', null, array('required' => true))
                ->add('routeKey', 'choice', array(
                    'required' => false,
                    'choices' => $this->getChoices(),
                ))
                ->add('position', 'hidden')
                ->add('parent', 'hidden', array(
                    'data_class' => 'AppBundle\Entity\MenuItem',
                ))
        ;
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement
                ->with('name')
                ->assertNotBlank()
                ->end()
//                ->with('site')
//                ->assertNotBlank()
//                ->end()
        ;
    }

    private function getChoices()
    {
        $site = $this->request->query->get('site', 1);

        $pages = $this->pageManager->findBy(array('site' => $site), array('url' => 'ASC'));

        $choices = array();
        foreach ($this->avaiableRoutes as $name => $values) {
            $route = $values['route'];
            $choices[$name] = $name;
        }

        return $choices;
    }

    public function getPageManager()
    {
        return $this->pageManager;
    }

    public function setPageManager(PageManager $pageManager)
    {
        $this->pageManager = $pageManager;

        return $this;
    }

}
