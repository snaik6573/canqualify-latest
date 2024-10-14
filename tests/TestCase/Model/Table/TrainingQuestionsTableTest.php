<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TrainingQuestionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TrainingQuestionsTable Test Case
 */
class TrainingQuestionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TrainingQuestionsTable
     */
    public $TrainingQuestions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TrainingQuestions',
        'app.QuestionTypes',
        'app.Trainings',
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
        $config = TableRegistry::getTableLocator()->exists('TrainingQuestions') ? [] : ['className' => TrainingQuestionsTable::class];
        $this->TrainingQuestions = TableRegistry::getTableLocator()->get('TrainingQuestions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TrainingQuestions);

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
