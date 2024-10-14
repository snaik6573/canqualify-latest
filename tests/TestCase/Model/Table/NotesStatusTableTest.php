<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NotesStatusTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NotesStatusTable Test Case
 */
class NotesStatusTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\NotesStatusTable
     */
    public $NotesStatus;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.NotesStatus',
        'app.Contractors',
        'app.Users',
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
        $config = TableRegistry::getTableLocator()->exists('NotesStatus') ? [] : ['className' => NotesStatusTable::class];
        $this->NotesStatus = TableRegistry::getTableLocator()->get('NotesStatus', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->NotesStatus);

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
