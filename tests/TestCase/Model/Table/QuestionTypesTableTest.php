<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\QuestionTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\QuestionTypesTable Test Case
 */
class QuestionTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\QuestionTypesTable
     */
    public $QuestionTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.QuestionTypes',
        'app.Questions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('QuestionTypes') ? [] : ['className' => QuestionTypesTable::class];
        $this->QuestionTypes = TableRegistry::getTableLocator()->get('QuestionTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->QuestionTypes);

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
