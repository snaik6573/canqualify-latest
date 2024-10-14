<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmailQueuesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmailQueuesTable Test Case
 */
class EmailQueuesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EmailQueuesTable
     */
    public $EmailQueues;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.EmailQueues'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EmailQueues') ? [] : ['className' => EmailQueuesTable::class];
        $this->EmailQueues = TableRegistry::getTableLocator()->get('EmailQueues', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EmailQueues);

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
