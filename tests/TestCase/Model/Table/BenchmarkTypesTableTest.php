<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BenchmarkTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BenchmarkTypesTable Test Case
 */
class BenchmarkTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BenchmarkTypesTable
     */
    public $BenchmarkTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.BenchmarkTypes',
        'app.Benchmarks'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('BenchmarkTypes') ? [] : ['className' => BenchmarkTypesTable::class];
        $this->BenchmarkTypes = TableRegistry::getTableLocator()->get('BenchmarkTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->BenchmarkTypes);

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
