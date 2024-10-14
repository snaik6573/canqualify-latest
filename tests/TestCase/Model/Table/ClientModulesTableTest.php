<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ClientModulesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ClientModulesTable Test Case
 */
class ClientModulesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ClientModulesTable
     */
    public $ClientModules;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ClientModules',
        'app.Clients',
        'app.Modules'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ClientModules') ? [] : ['className' => ClientModulesTable::class];
        $this->ClientModules = TableRegistry::getTableLocator()->get('ClientModules', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ClientModules);

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
