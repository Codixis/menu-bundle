<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mojo\Bundle\MenuBundle\Block\Service;

use Application\Sonata\PageBundle\Block\PreviewBlockServiceInterface;
use Mojo\Bundle\CoreBundle\Block\Helper\CoreBlockHelperInterface;
use Mojo\Bundle\MenuBundle\Menu\MenuBuilder;
use Mojo\Bundle\MenuBundle\Model\MenuInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class MenuBlockService.
 *
 *
 * @author Hugo Briand <briand@ekino.com>
 */
class MenuBlockService extends BaseBlockService implements PreviewBlockServiceInterface
{
    /**
     * @var MenuBuilder
     */
    protected $builder;

    /**
     * @var CoreBlockHelperInterface;
     */
    protected $menuHelper;

    public function getMenuHelper()
    {
        return $this->menuHelper;
    }

    public function setMenuHelper(CoreBlockHelperInterface $menuHelper)
    {
        $this->menuHelper = $menuHelper;

        return $this;
    }

    public function getBuilder()
    {
        return $this->builder;
    }

    public function setBuilder(MenuBuilder $builder)
    {
        $this->builder = $builder;

        return $this;
    }

    public function thumb(Response $response = null)
    {
    }

    public function preview(BlockContextInterface $blockContext, Response $response = null)
    {
        return $this->execute($blockContext, $response);
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $menu = $blockContext->getBlock()->getSetting('menu');
        $settings = $blockContext->getBlock()->getSettings();

        $this->menuHelper->refresh($menu);

        $knpMenu = $this->builder->createMenu($menu);

        return $this->renderResponse($blockContext->getTemplate(), array(
                    'menu' => $knpMenu,
                    'settings' => $settings,
                        ), $response);
    }

    /**
     * {@inheritdoc}
     */
    public function load(BlockInterface $block)
    {
        $menu = $block->getSetting('menu', null);
        if (!$menu instanceof MenuInterface) {
            $menu = $this->menuHelper->find($menu);
        }
        $block->setSetting('menu', $menu);
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
        $styles = $this->getStyles();
        $builder = $this->menuHelper->getSelector($formMapper, 'menu');

        $formMapper->add('settings', 'sonata_type_immutable_array', array(
            'keys' => array(
                array($builder, null, array()),
                array('style', 'choice', array('required' => count($styles) > 0, 'choices' => $styles)),
            ),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'menu' => null,
            'template' => 'MojoMenuBundle:Block/Menu:menu.html.twig',
            'style' => 'tabs',
        ));
    }

    /**
     * @return array
     */
    protected function getStyles()
    {
        $templates = array();
        $templates['tabs'] = 'Tabs';
        $templates['justified-tabs'] = 'Justified Tabs';
        $templates['pills'] = 'Pills';
        $templates['stacked-pills'] = 'Stacked Pills';
        $templates['justified-pills'] = 'Justified Pills';
        $templates['navbar'] = 'Navbar';
        $templates['navbar-right'] = 'Navbar Right';

        return $templates;
    }

    /**
     * {@inheritdoc}
     */
    public function getImage()
    {
        return 'http://www.caseguitars.co.uk/images/news-september-thumb-3.jpg';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Menu';
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist(BlockInterface $block)
    {
        $menu = is_object($block->getSetting('menu')) ? $block->getSetting('menu')->getId() : null;
        $block->setSetting('menu', $menu);
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate(BlockInterface $block)
    {
        $menu = is_object($block->getSetting('menu')) ? $block->getSetting('menu')->getId() : null;

        $block->setSetting('menu', $menu);
    }
}
