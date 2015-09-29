<?php

namespace QEngine\Locale\Service;

use QEngine\Locale\ModuleOptions;
use Zend\Uri\UriInterface;

/**
 * Class LocaleNameParserServiceTest
 *
 * @package QEngine\Locale\Service
 * @author  Jakub Igla <jakub.igla@valtech.co.uk>
 */
class LocaleNameParserServiceTest extends \PHPUnit_Framework_TestCase
{
    const LOCALE_HEADER = 'pl_PL';

    /** @var \PHPUnit_Framework_MockObject_MockObject | ModuleOptions */
    private $moduleOptionsMock;

    /** @var \PHPUnit_Framework_MockObject_MockObject | UriInterface */
    private $uriMock;

    public function setUp()
    {
        parent::setUp();

        $this->moduleOptionsMock = $this->getMockBuilder(ModuleOptions::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->uriMock           = $this->getMockBuilder(UriInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testGetLocaleFromHost()
    {
        $validLocale = 'pl_PL';
        $host        = 'locale.qengine.com';

        $this->uriMock
            ->expects($this->once())
            ->method('getHost')
            ->willReturn($host);

        $this->moduleOptionsMock
            ->expects($this->any())
            ->method('getDomainMap')
            ->willReturn([$host => $validLocale]);

        $this->moduleOptionsMock
            ->expects($this->any())
            ->method('getAvailable')
            ->willReturn([$validLocale]);

        $service  = new LocaleNameParserService($this->moduleOptionsMock, $this->uriMock, self::LOCALE_HEADER);
        $response = $service->getLocaleFromHost();

        $this->assertEquals($validLocale, $response);
    }

    /**
     * @expectedException \QEngine\Locale\Exception\LocaleNotFoundException
     * @expectedExceptionMessage No locale is mapped to this host
     */
    public function testGetLocaleFromHostWithNoMappedDomain()
    {
        $host = 'locale.qengine.com';

        $this->uriMock
            ->expects($this->once())
            ->method('getHost')
            ->willReturn($host);

        $this->moduleOptionsMock
            ->expects($this->any())
            ->method('getDomainMap')
            ->willReturn([]);

        $service  = new LocaleNameParserService($this->moduleOptionsMock, $this->uriMock, self::LOCALE_HEADER);
        $service->getLocaleFromHost();
    }
}
