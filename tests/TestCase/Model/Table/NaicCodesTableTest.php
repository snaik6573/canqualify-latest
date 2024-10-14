<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NaicCodesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NaicCodesTable Test Case
 */
class NaicCodesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\NaicCodesTable
     */
    public $NaicCodes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.NaicCodes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('NaicCodes') ? [] : ['className' => NaicCodesTable::class];
        $this->NaicCodes = TableRegistry::getTableLocator()->get('NaicCodes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->NaicCodes);

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
