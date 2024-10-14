<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FeedbackAnswersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FeedbackAnswersTable Test Case
 */
class FeedbackAnswersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FeedbackAnswersTable
     */
    public $FeedbackAnswers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.FeedbackAnswers',
        'app.Contractors',
        'app.FeedbackQuestions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('FeedbackAnswers') ? [] : ['className' => FeedbackAnswersTable::class];
        $this->FeedbackAnswers = TableRegistry::getTableLocator()->get('FeedbackAnswers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FeedbackAnswers);

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
