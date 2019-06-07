<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OfficersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OfficersTable Test Case
 */
class OfficersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OfficersTable
     */
    public $Officers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.officers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Officers') ? [] : ['className' => OfficersTable::class];
        $this->Officers = TableRegistry::getTableLocator()->get('Officers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Officers);

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
