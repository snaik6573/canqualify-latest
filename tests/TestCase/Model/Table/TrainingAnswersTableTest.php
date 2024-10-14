<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TrainingAnswersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TrainingAnswersTable Test Case
 */
class TrainingAnswersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TrainingAnswersTable
     */
    public $TrainingAnswers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TrainingAnswers',
        'app.Employees',
        'app.TrainingQuestions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TrainingAnswers') ? [] : ['className' => TrainingAnswersTable::class];
        $this->TrainingAnswers = TableRegistry::getTableLocator()->get('TrainingAnswers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TrainingAnswers);

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
