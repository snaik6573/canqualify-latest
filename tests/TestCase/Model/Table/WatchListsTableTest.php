<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WatchListsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WatchListsTable Test Case
 */
class WatchListsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\WatchListsTable
     */
    public $WatchLists;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.WatchLists',
        'app.Contractors',
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
        $config = TableRegistry::getTableLocator()->exists('WatchLists') ? [] : ['className' => WatchListsTable::class];
        $this->WatchLists = TableRegistry::getTableLocator()->get('WatchLists', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->WatchLists);

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
