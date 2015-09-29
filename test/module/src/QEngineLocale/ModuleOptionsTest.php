<?php

namespace QEngine\Locale;

/**
 * Class ModuleOptionsTest
 *
 * @package QEngine\Locale
 * @author Jakub Igla <jakub.igla@valtech.co.uk>
 */
class ModuleOptionsTest extends \PHPUnit_Framework_TestCase
{
    /** @var ModuleOptions */
    private $options;

    public function setUp()
    {
        $this->options = new ModuleOptions();
    }

    public function testSettersAndGetters()
    {
        $this->assertEquals(true, $this->options->setMultiLanguage(true)->isMultiLanguage());
        $this->assertEquals([], $this->options->setAvailable([])->getAvailable());
        $this->assertEquals('string', $this->options->setDefault('string')->getDefault());
        $this->assertEquals([], $this->options->setDomainMap([])->getDomainMap());
        $this->assertEquals(true, $this->options->setMappedDomainRedirectable(true)->isMappedDomainRedirectable());
    }
}
