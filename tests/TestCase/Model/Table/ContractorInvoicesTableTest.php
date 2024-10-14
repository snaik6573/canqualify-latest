<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ContractorInvoicesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ContractorInvoicesTable Test Case
 */
class ContractorInvoicesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ContractorInvoicesTable
     */
    public $ContractorInvoices;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ContractorInvoices',
        'app.Contractors',
        'app.Services',
        'app.Payments'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ContractorInvoices') ? [] : ['className' => ContractorInvoicesTable::class];
        $this->ContractorInvoices = TableRegistry::getTableLocator()->get('ContractorInvoices', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ContractorInvoices);

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
