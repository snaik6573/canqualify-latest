<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ClientEmployeeRequestsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ClientEmployeeRequestsTable Test Case
 */
class ClientEmployeeRequestsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ClientEmployeeRequestsTable
     */
    public $ClientEmployeeRequests;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ClientEmployeeRequests',
        'app.Clients',
        'app.Employees'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ClientEmployeeRequests') ? [] : ['className' => ClientEmployeeRequestsTable::class];
        $this->ClientEmployeeRequests = TableRegistry::getTableLocator()->get('ClientEmployeeRequests', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ClientEmployeeRequests);

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
