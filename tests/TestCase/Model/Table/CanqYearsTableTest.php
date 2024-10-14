<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CanqYearsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CanqYearsTable Test Case
 */
class CanqYearsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CanqYearsTable
     */
    public $CanqYears;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CanqYears'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CanqYears') ? [] : ['className' => CanqYearsTable::class];
        $this->CanqYears = TableRegistry::getTableLocator()->get('CanqYears', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CanqYears);

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
