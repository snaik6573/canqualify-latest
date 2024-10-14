<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CronClientAddTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CronClientAddTable Test Case
 */
class CronClientAddTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CronClientAddTable
     */
    public $CronClientAdd;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CronClientAdd',
        'app.Contractors',
        'app.Clients'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CronClientAdd') ? [] : ['className' => CronClientAddTable::class];
        $this->CronClientAdd = TableRegistry::getTableLocator()->get('CronClientAdd', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CronClientAdd);

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
