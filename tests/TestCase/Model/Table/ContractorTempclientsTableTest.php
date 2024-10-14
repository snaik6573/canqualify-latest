<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ContractorTempclientsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ContractorTempclientsTable Test Case
 */
class ContractorTempclientsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ContractorTempclientsTable
     */
    public $ContractorTempclients;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ContractorTempclients',
        'app.Contractors',
        'app.Sites',
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
        $config = TableRegistry::getTableLocator()->exists('ContractorTempclients') ? [] : ['className' => ContractorTempclientsTable::class];
        $this->ContractorTempclients = TableRegistry::getTableLocator()->get('ContractorTempclients', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ContractorTempclients);

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
