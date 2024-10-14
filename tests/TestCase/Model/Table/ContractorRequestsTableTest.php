<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ContractorRequestsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ContractorRequestsTable Test Case
 */
class ContractorRequestsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ContractorRequestsTable
     */
    public $ContractorRequests;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ContractorRequests',
        'app.Contractors',
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
        $config = TableRegistry::getTableLocator()->exists('ContractorRequests') ? [] : ['className' => ContractorRequestsTable::class];
        $this->ContractorRequests = TableRegistry::getTableLocator()->get('ContractorRequests', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ContractorRequests);

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
