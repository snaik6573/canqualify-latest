<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ContractorsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ContractorsTable Test Case
 */
class ContractorsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ContractorsTable
     */
    public $Contractors;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Contractors',
        'app.States',
        'app.Countries',
        'app.Users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Contractors') ? [] : ['className' => ContractorsTable::class];
        $this->Contractors = TableRegistry::getTableLocator()->get('Contractors', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Contractors);

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
