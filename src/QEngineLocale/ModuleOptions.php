<?php

namespace QEngineLocale;

use Zend\Stdlib\AbstractOptions;

/**
 * Class ModuleOptions
 *
 * @package QEngineLocale
 * @author Jakub Igla <jakub.igla@gmail.com>
 */
class ModuleOptions extends AbstractOptions
{
    /** @var bool */
    private $multiLingual;

    /** @var array */
    private $available;

    /** @var string */
    private $default;

    /**
     * @return boolean
     */
    public function isMultiLingual()
    {
        return $this->multiLingual;
    }

    /**
     * @param boolean $multiLingual
     *
     * @return $this
     */
    public function setMultiLingual($multiLingual)
    {
        $this->multiLingual = $multiLingual;
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
}
