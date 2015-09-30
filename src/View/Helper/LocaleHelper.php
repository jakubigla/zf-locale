<?php

namespace QEngine\Locale\View\Helper;

use QEngine\Locale\ModuleOptions;
use Zend\View\Helper\AbstractHelper;

/**
 * Class Locale
 *
 * @package QEngine\Locale\View\Helper
 * @author Jakub Igla <jakub.igla@valtech.co.uk>
 */
class LocaleHelper extends AbstractHelper
{
    /** @var ModuleOptions */
    private $moduleOptions;
    /**
     * LocaleHelper constructor.
     *
     * @param ModuleOptions $moduleOptions
     */
    public function __construct(ModuleOptions $moduleOptions)
    {
        $this->moduleOptions = $moduleOptions;
    }

    public function __invoke()
    {
        return $this;
    }

    public function getOptions()
    {
        return $this->moduleOptions;
    }

    public function getSwitchUrl($locale)
    {
        
    }
}