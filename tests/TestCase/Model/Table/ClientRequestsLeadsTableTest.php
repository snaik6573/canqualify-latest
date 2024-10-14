<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ClientRequestsLeadsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ClientRequestsLeadsTable Test Case
 */
class ClientRequestsLeadsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ClientRequestsLeadsTable
     */
    public $ClientRequestsLeads;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ClientRequestsLeads',
        'app.Clients',
        'app.Leads'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ClientRequestsLeads') ? [] : ['className' => ClientRequestsLeadsTable::class];
        $this->ClientRequestsLeads = TableRegistry::getTableLocator()->get('ClientRequestsLeads', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ClientRequestsLeads);

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
