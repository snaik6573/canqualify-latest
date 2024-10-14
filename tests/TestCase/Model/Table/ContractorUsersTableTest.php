<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ContractorUsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ContractorUsersTable Test Case
 */
class ContractorUsersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ContractorUsersTable
     */
    public $ContractorUsers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ContractorUsers',
        'app.Users',
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
        $config = TableRegistry::getTableLocator()->exists('ContractorUsers') ? [] : ['className' => ContractorUsersTable::class];
        $this->ContractorUsers = TableRegistry::getTableLocator()->get('ContractorUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ContractorUsers);

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
