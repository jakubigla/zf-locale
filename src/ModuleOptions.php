<?php

namespace QEngine\Locale;

use Zend\Stdlib\AbstractOptions;

/**
 * Class ModuleOptions
 *
 * @package QEngine\Locale
 * @author Jakub Igla <jakub.igla@gmail.com>
 */
class ModuleOptions extends AbstractOptions
{
    /** @var bool */
    private $multiLanguage;

    /** @var array */
    private $available;

    /** @var string */
    private $default;

    /** @var array */
    private $domainMap;

    /** @var bool */
    private $mappedDomainRedirectable;

    private $currentLocale;

    /**
     * @return boolean
     */
    public function isMultiLanguage()
    {
        return $this->multiLanguage;
    }

    /**
     * @param boolean $multiLanguage
     *
     * @return $this
     */
    public function setMultiLanguage($multiLanguage)
    {
        $this->multiLanguage = $multiLanguage;
        return $this;
    }

    /**
     * @return array
     */
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * @param array $available
     *
     * @return $this
     */
    public function setAvailable($available)
    {
        $this->available = $available;
        return $this;
    }

    /**
     * @return string
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @param string $default
     *
     * @return $this
     */
    public function setDefault($default)
    {
        $this->default = $default;
        return $this;
    }

    /**
     * @return array
     */
    public function getDomainMap()
    {
        return $this->domainMap;
    }

    /**
     * @param array $domainMap
     *
     * @return $this
     */
    public function setDomainMap($domainMap)
    {
        $this->domainMap = $domainMap;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isMappedDomainRedirectable()
    {
        return $this->mappedDomainRedirectable;
    }

    /**
     * @param boolean $mappedDomainRedirectable
     *
     * @return $this
     */
    public function setMappedDomainRedirectable($mappedDomainRedirectable)
    {
        $this->mappedDomainRedirectable = $mappedDomainRedirectable;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCurrentLocale()
    {
        if (empty($this->currentLocale)) {
            return $this->getDefault();
        }
        return $this->currentLocale;
    }

    /**
     * @param mixed $currentLocale
     *
     * @return $this
     */
    public function setCurrentLocale($currentLocale)
    {
        $this->currentLocale = $currentLocale;
        return $this;
    }
}
