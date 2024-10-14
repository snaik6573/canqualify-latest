<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SiteVisitsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SiteVisitsTable Test Case
 */
class SiteVisitsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SiteVisitsTable
     */
    public $SiteVisits;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.SiteVisits',
        'app.Contractors',
        'app.Sites'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('SiteVisits') ? [] : ['className' => SiteVisitsTable::class];
        $this->SiteVisits = TableRegistry::getTableLocator()->get('SiteVisits', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SiteVisits);

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
