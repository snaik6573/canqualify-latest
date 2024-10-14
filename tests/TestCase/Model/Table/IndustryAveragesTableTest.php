<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\IndustryAveragesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\IndustryAveragesTable Test Case
 */
class IndustryAveragesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\IndustryAveragesTable
     */
    public $IndustryAverages;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.IndustryAverages',
        'app.NaiscCodes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('IndustryAverages') ? [] : ['className' => IndustryAveragesTable::class];
        $this->IndustryAverages = TableRegistry::getTableLocator()->get('IndustryAverages', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->IndustryAverages);

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
