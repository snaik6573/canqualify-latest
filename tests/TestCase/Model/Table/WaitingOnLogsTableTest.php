<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WaitingOnLogsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WaitingOnLogsTable Test Case
 */
class WaitingOnLogsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\WaitingOnLogsTable
     */
    public $WaitingOnLogs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.WaitingOnLogs',
        'app.Contractors'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('WaitingOnLogs') ? [] : ['className' => WaitingOnLogsTable::class];
        $this->WaitingOnLogs = TableRegistry::getTableLocator()->get('WaitingOnLogs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->WaitingOnLogs);

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
