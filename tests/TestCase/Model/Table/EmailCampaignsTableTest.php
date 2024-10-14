<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmailCampaignsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmailCampaignsTable Test Case
 */
class EmailCampaignsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EmailCampaignsTable
     */
    public $EmailCampaigns;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.EmailCampaigns'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EmailCampaigns') ? [] : ['className' => EmailCampaignsTable::class];
        $this->EmailCampaigns = TableRegistry::getTableLocator()->get('EmailCampaigns', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EmailCampaigns);

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
