<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SuggestedIconsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SuggestedIconsTable Test Case
 */
class SuggestedIconsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SuggestedIconsTable
     */
    public $SuggestedIcons;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.SuggestedIcons',
        'app.Clients',
        'app.Contractors',
        'app.SuggestedOverallIcons'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('SuggestedIcons') ? [] : ['className' => SuggestedIconsTable::class];
        $this->SuggestedIcons = TableRegistry::getTableLocator()->get('SuggestedIcons', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SuggestedIcons);

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
