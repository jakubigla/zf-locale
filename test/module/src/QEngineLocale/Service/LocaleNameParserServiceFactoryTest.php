<?php

namespace QEngine\Locale\Service;

use QEngine\Locale\ModuleOptions;
use Zend\Http\PhpEnvironment\Request as PhpRequest;
use Zend\Stdlib\Request as StdRequest;
use Zend\ServiceManager\ServiceManager;
use Zend\Uri\UriInterface;

/**
 * Class LocaleNameParserServiceFactoryTest
 *
 * @package QEngine\Locale\Service
 * @author Jakub Igla <jakub.igla@valtech.co.uk>
 */
class LocaleNameParserServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateService()
    {
        $requestMock       = $this->getMockBuilder(PhpRequest::class)->disableOriginalConstructor()->getMock();
        $moduleOptionsMock = $this->getMockBuilder(ModuleOptions::class)->disableOriginalConstructor()->getMock();

        $requestMock
            ->expects($this->once())
            ->method('getUri')
            ->willReturn($this->getMock(UriInterface::class));

        $serviceManager = new ServiceManager();
        $serviceManager
            ->setService(ModuleOptions::class, $moduleOptionsMock)
            ->setService('Request', $requestMock);

        $factory = new LocaleNameParserServiceFactory();
        $service = $factory->createService($serviceManager);

        $this->assertInstanceOf(LocaleNameParserService::class, $service);
    }

    /**
     * @expectedException \Zend\ServiceManager\Exception\RuntimeException
     * @expectedExceptionMessage Only request of Http type can work with this service
     */
    public function testCreateServiceWithWrongRequest()
    {
        $requestMock = $this->getMockBuilder(StdRequest::class)->disableOriginalConstructor()->getMock();

        $serviceManager = new ServiceManager();
        $serviceManager->setService('Request', $requestMock);

        $factory = new LocaleNameParserServiceFactory();
        $factory->createService($serviceManager);
    }
}
