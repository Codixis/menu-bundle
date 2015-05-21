<?php

namespace Mojo\Bundle\MenuBundle\Manager;

use Mojo\Bundle\PublicationBundle\Manager\PublicationManagerInterface;
use Sonata\CoreBundle\Model\BaseEntityManager;
use Sonata\DatagridBundle\Pager\Doctrine\Pager;
use Sonata\DatagridBundle\ProxyQuery\Doctrine\ProxyQuery;

class MenuManager extends BaseEntityManager implements PublicationManagerInterface {

    /**
     * {@inheritdoc}
     *
     * Valid criteria are:
     *    enabled - boolean
     *    date - query
     *    tag - string
     *    author - 'NULL', 'NOT NULL', id, array of ids
     *    collections - CollectionInterface
     *    mode - string public|admin
     */
    public function getPager(array $criteria, $page, $limit = 10, array $sort = array()) {
        
        if (!isset($criteria['mode'])) {
            $criteria['mode'] = 'public';
        }

        $parameters = array();
        $query = $this->getRepository()
                ->createQueryBuilder('p')
                ->select('p');

        if (isset($criteria['name'])) {

            $query->andWhere('p.name LIKE :name');
            $parameters['name'] = (string) $criteria['name'];
        }

        if (isset($criteria['site'])) {
            if (!is_array($criteria['site']) && stristr($criteria['site'], 'NULL')) {
                $query->andWhere('p.site IS ' . $criteria['site']);
            } else {
                $query->andWhere(sprintf('p.site IN (%s)', implode((array) $criteria['site'], ',')));
            }
        }

        $query->setParameters($parameters);

        $pager = new Pager();
        $pager->setMaxPerPage($limit);
        $pager->setQuery(new ProxyQuery($query));
        $pager->setPage($page);
        $pager->init();

        return $pager;
    }

}
