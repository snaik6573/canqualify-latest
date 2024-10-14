<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TempEmployeeSlotsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TempEmployeeSlotsTable Test Case
 */
class TempEmployeeSlotsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TempEmployeeSlotsTable
     */
    public $TempEmployeeSlots;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TempEmployeeSlots'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TempEmployeeSlots') ? [] : ['className' => TempEmployeeSlotsTable::class];
        $this->TempEmployeeSlots = TableRegistry::getTableLocator()->get('TempEmployeeSlots', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TempEmployeeSlots);

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
}
