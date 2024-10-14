<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ClientEmployeeQuestionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ClientEmployeeQuestionsTable Test Case
 */
class ClientEmployeeQuestionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ClientEmployeeQuestionsTable
     */
    public $ClientEmployeeQuestions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ClientEmployeeQuestions',
        'app.Clients',
        'app.EmployeeQuestions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ClientEmployeeQuestions') ? [] : ['className' => ClientEmployeeQuestionsTable::class];
        $this->ClientEmployeeQuestions = TableRegistry::getTableLocator()->get('ClientEmployeeQuestions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ClientEmployeeQuestions);

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
