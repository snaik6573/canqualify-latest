<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FinalOverallIconsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FinalOverallIconsTable Test Case
 */
class FinalOverallIconsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FinalOverallIconsTable
     */
    public $FinalOverallIcons;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.FinalOverallIcons',
        'app.Clients',
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
        $config = TableRegistry::getTableLocator()->exists('FinalOverallIcons') ? [] : ['className' => FinalOverallIconsTable::class];
        $this->FinalOverallIcons = TableRegistry::getTableLocator()->get('FinalOverallIcons', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FinalOverallIcons);

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
