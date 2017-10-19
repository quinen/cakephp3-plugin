<?php
namespace Quinen\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Quinen\Model\Table\QnnGrpGroupsTable;

/**
 * Quinen\Model\Table\QnnGrpGroupsTable Test Case
 */
class QnnGrpGroupsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Quinen\Model\Table\QnnGrpGroupsTable
     */
    public $QnnGrpGroups;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.quinen.qnn_grp_groups',
        'plugin.quinen.grps'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('QnnGrpGroups') ? [] : ['className' => QnnGrpGroupsTable::class];
        $this->QnnGrpGroups = TableRegistry::get('QnnGrpGroups', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->QnnGrpGroups);

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
