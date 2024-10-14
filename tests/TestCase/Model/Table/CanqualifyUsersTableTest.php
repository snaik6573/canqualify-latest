<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CanqualifyUsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CanqualifyUsersTable Test Case
 */
class CanqualifyUsersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CanqualifyUsersTable
     */
    public $CanqualifyUsers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CanqualifyUsers',
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
        $config = TableRegistry::getTableLocator()->exists('CanqualifyUsers') ? [] : ['className' => CanqualifyUsersTable::class];
        $this->CanqualifyUsers = TableRegistry::getTableLocator()->get('CanqualifyUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CanqualifyUsers);

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
