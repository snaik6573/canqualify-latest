<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ContractorSitesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ContractorSitesTable Test Case
 */
class ContractorSitesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ContractorSitesTable
     */
    public $ContractorSites;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ContractorSites',
        'app.Contractors',
        'app.Sites'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ContractorSites') ? [] : ['className' => ContractorSitesTable::class];
        $this->ContractorSites = TableRegistry::getTableLocator()->get('ContractorSites', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ContractorSites);

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
