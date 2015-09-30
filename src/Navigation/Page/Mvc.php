<?php

namespace QEngine\Locale\Navigation\Page;

use Zend\Navigation\Page\Mvc as ZendMvc;
use Zend\Navigation\Exception;

class Mvc extends ZendMvc
{
    /**
     * Returns href for this page
     *
     * This method uses {@link RouteStackInterface} to assemble
     * the href based on the page's properties.
     *
     * @see RouteStackInterface
     * @return string  page href
     * @throws Exception\DomainException if no router is set
     */
    public function getHref()
    {
        $url = parent::getHref();

        if (!empty($this->get('locale'))) {
            $url = '/' . $this->get('locale') . $url;
        }

        return $url;
    }
}
