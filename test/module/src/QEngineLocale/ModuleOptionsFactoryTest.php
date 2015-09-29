<?php

namespace QEngine\Locale;

use Zend\ServiceManager\ServiceManager;

/**
 * Class ModuleOptionsFactoryTest
 *
 * @package QEngine\Locale
 * @author Jakub Igla <jakub.igla@valtech.co.uk>
 */
class ModuleOptionsFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateService()
    {
        $serviceManager = new ServiceManager();
        $serviceManager->setService('Config', [__NAMESPACE__ => []]);

        $serviceFactory = new ModuleOptionsFactory();
        $service        = $serviceFactory->createService($serviceManager);

        $this->assertInstanceOf(ModuleOptions::class, $service);
    }
}
