<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SuggestedOverallIconsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SuggestedOverallIconsTable Test Case
 */
class SuggestedOverallIconsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SuggestedOverallIconsTable
     */
    public $SuggestedOverallIcons;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.SuggestedOverallIcons',
        'app.Clients',
        'app.Contractors',
        'app.SuggestedIcons'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('SuggestedOverallIcons') ? [] : ['className' => SuggestedOverallIconsTable::class];
        $this->SuggestedOverallIcons = TableRegistry::getTableLocator()->get('SuggestedOverallIcons', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SuggestedOverallIcons);

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
