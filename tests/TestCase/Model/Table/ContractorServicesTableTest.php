<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ContractorServicesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ContractorServicesTable Test Case
 */
class ContractorServicesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ContractorServicesTable
     */
    public $ContractorServices;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ContractorServices',
        'app.Contractors',
        'app.Services'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ContractorServices') ? [] : ['className' => ContractorServicesTable::class];
        $this->ContractorServices = TableRegistry::getTableLocator()->get('ContractorServices', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ContractorServices);

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
