<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FeedbackQuestionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FeedbackQuestionsTable Test Case
 */
class FeedbackQuestionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FeedbackQuestionsTable
     */
    public $FeedbackQuestions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.FeedbackQuestions',
        'app.FeedbackAnswers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('FeedbackQuestions') ? [] : ['className' => FeedbackQuestionsTable::class];
        $this->FeedbackQuestions = TableRegistry::getTableLocator()->get('FeedbackQuestions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FeedbackQuestions);

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
