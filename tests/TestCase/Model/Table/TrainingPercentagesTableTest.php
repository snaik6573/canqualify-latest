<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TrainingPercentagesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TrainingPercentagesTable Test Case
 */
class TrainingPercentagesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TrainingPercentagesTable
     */
    public $TrainingPercentages;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TrainingPercentages',
        'app.Trainings',
        'app.Employees',
        'app.Contractors',
        'app.Clients'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TrainingPercentages') ? [] : ['className' => TrainingPercentagesTable::class];
        $this->TrainingPercentages = TableRegistry::getTableLocator()->get('TrainingPercentages', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TrainingPercentages);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
