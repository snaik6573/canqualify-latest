<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ExplanationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ExplanationsTable Test Case
 */
class ExplanationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ExplanationsTable
     */
    public $Explanations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Explanations',
        'app.Contractors'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Explanations') ? [] : ['className' => ExplanationsTable::class];
        $this->Explanations = TableRegistry::getTableLocator()->get('Explanations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Explanations);

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
