<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LeadStatusTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LeadStatusTable Test Case
 */
class LeadStatusTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LeadStatusTable
     */
    public $LeadStatus;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.LeadStatus'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('LeadStatus') ? [] : ['className' => LeadStatusTable::class];
        $this->LeadStatus = TableRegistry::getTableLocator()->get('LeadStatus', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LeadStatus);

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
}
