<?php

namespace Amitshree\Marketplace\Test\Integration;

use Magento\Framework\Component\ComponentRegistrar;
use Magento\Framework\Module\ModuleList;
use Magento\TestFramework\ObjectManager;

class ModuleConfigTest extends \PHPUnit_Framework_TestCase
{
    private $subjectModuleName;

    /**
     * @var $objectManager ObjectManager
     */
    private $objectManager;

    protected function setUp()
    {
        $this->subjectModuleName = 'Amitshree_Marketplace';
        $this->objectManager = ObjectManager::getInstance();
    }
    public function testTheModuleIsRegistered()
    {
        $registrar = new ComponentRegistrar();
        $this->assertArrayHasKey('Amitshree_Marketplace', $registrar->getPaths(ComponentRegistrar::MODULE));
    }

}
