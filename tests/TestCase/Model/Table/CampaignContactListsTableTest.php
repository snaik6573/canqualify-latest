<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CampaignContactListsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CampaignContactListsTable Test Case
 */
class CampaignContactListsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CampaignContactListsTable
     */
    public $CampaignContactLists;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CampaignContactLists'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CampaignContactLists') ? [] : ['className' => CampaignContactListsTable::class];
        $this->CampaignContactLists = TableRegistry::getTableLocator()->get('CampaignContactLists', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CampaignContactLists);

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
