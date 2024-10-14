<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ClientUsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ClientUsersTable Test Case
 */
class ClientUsersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ClientUsersTable
     */
    public $ClientUsers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ClientUsers',
        'app.Users',
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
        $config = TableRegistry::getTableLocator()->exists('ClientUsers') ? [] : ['className' => ClientUsersTable::class];
        $this->ClientUsers = TableRegistry::getTableLocator()->get('ClientUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ClientUsers);

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
