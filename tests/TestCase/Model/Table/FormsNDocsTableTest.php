<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FormsNDocsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FormsNDocsTable Test Case
 */
class FormsNDocsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FormsNDocsTable
     */
    public $FormsNDocs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.FormsNDocs',
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
        $config = TableRegistry::getTableLocator()->exists('FormsNDocs') ? [] : ['className' => FormsNDocsTable::class];
        $this->FormsNDocs = TableRegistry::getTableLocator()->get('FormsNDocs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FormsNDocs);

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
