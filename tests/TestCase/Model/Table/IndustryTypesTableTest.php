<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\IndustryTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\IndustryTypesTable Test Case
 */
class IndustryTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\IndustryTypesTable
     */
    public $IndustryTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.IndustryTypes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('IndustryTypes') ? [] : ['className' => IndustryTypesTable::class];
        $this->IndustryTypes = TableRegistry::getTableLocator()->get('IndustryTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->IndustryTypes);

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
