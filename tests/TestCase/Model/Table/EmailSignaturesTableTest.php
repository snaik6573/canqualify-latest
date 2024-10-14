<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmailSignaturesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmailSignaturesTable Test Case
 */
class EmailSignaturesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EmailSignaturesTable
     */
    public $EmailSignatures;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.EmailSignatures',
        'app.Templates'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EmailSignatures') ? [] : ['className' => EmailSignaturesTable::class];
        $this->EmailSignatures = TableRegistry::getTableLocator()->get('EmailSignatures', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EmailSignatures);

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
