<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WaitingOnTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WaitingOnTable Test Case
 */
class WaitingOnTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\WaitingOnTable
     */
    public $WaitingOn;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.WaitingOn'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('WaitingOn') ? [] : ['className' => WaitingOnTable::class];
        $this->WaitingOn = TableRegistry::getTableLocator()->get('WaitingOn', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->WaitingOn);

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
