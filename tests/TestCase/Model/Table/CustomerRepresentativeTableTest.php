<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CustomerRepresentativeTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CustomerRepresentativeTable Test Case
 */
class CustomerRepresentativeTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CustomerRepresentativeTable
     */
    public $CustomerRepresentative;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CustomerRepresentative',
        'app.Users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CustomerRepresentative') ? [] : ['className' => CustomerRepresentativeTable::class];
        $this->CustomerRepresentative = TableRegistry::getTableLocator()->get('CustomerRepresentative', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CustomerRepresentative);

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
