<?php
namespace App\Test\TestCase\View\Helper;

use App\View\Helper\NotificationsHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\NotificationsHelper Test Case
 */
class NotificationsHelperTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\View\Helper\NotificationsHelper
     */
    public $Notifications;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->Notifications = new NotificationsHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Notifications);

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
