<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OverallIconsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OverallIconsTable Test Case
 */
class OverallIconsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OverallIconsTable
     */
    public $OverallIcons;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.OverallIcons',
        'app.Clients',
        'app.Contractors',
        'app.Icons'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('OverallIcons') ? [] : ['className' => OverallIconsTable::class];
        $this->OverallIcons = TableRegistry::getTableLocator()->get('OverallIcons', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OverallIcons);

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
