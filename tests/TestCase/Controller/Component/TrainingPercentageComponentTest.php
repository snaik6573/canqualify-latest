<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\TrainingPercentageComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\TrainingPercentageComponent Test Case
 */
class TrainingPercentageComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Controller\Component\TrainingPercentageComponent
     */
    public $TrainingPercentage;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->TrainingPercentage = new TrainingPercentageComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TrainingPercentage);

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
