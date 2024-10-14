<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ContractorTempsitesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ContractorTempsitesTable Test Case
 */
class ContractorTempsitesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ContractorTempsitesTable
     */
    public $ContractorTempsites;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ContractorTempsites',
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
        $config = TableRegistry::getTableLocator()->exists('ContractorTempsites') ? [] : ['className' => ContractorTempsitesTable::class];
        $this->ContractorTempsites = TableRegistry::getTableLocator()->get('ContractorTempsites', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ContractorTempsites);

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
