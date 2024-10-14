<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ClientNotesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ClientNotesTable Test Case
 */
class ClientNotesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ClientNotesTable
     */
    public $ClientNotes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ClientNotes',
        'app.Contractors',
        'app.CustomerRepresentatives',
        'app.Roles'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ClientNotes') ? [] : ['className' => ClientNotesTable::class];
        $this->ClientNotes = TableRegistry::getTableLocator()->get('ClientNotes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ClientNotes);

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
