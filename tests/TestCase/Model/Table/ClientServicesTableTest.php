<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ClientServicesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ClientServicesTable Test Case
 */
class ClientServicesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ClientServicesTable
     */
    public $ClientServices;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ClientServices',
        'app.Clients',
        'app.Services'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ClientServices') ? [] : ['className' => ClientServicesTable::class];
        $this->ClientServices = TableRegistry::getTableLocator()->get('ClientServices', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ClientServices);

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
