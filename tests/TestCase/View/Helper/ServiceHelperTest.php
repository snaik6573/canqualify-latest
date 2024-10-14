<?php
namespace App\Test\TestCase\View\Helper;

use App\View\Helper\ServiceHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\ServiceHelper Test Case
 */
class ServiceHelperTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\View\Helper\ServiceHelper
     */
    public $Service;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->Service = new ServiceHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Service);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
