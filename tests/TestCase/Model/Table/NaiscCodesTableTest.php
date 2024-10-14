<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NaiscCodesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NaiscCodesTable Test Case
 */
class NaiscCodesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\NaiscCodesTable
     */
    public $NaiscCodes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.NaiscCodes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('NaiscCodes') ? [] : ['className' => NaiscCodesTable::class];
        $this->NaiscCodes = TableRegistry::getTableLocator()->get('NaiscCodes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->NaiscCodes);

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
