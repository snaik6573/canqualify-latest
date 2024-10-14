<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CustomerrNotesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CustomerrNotesTable Test Case
 */
class CustomerrNotesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CustomerrNotesTable
     */
    public $CustomerrNotes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CustomerrNotes',
        'app.Contractors',
        'app.CustomerRepresentative'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CustomerrNotes') ? [] : ['className' => CustomerrNotesTable::class];
        $this->CustomerrNotes = TableRegistry::getTableLocator()->get('CustomerrNotes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CustomerrNotes);

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
