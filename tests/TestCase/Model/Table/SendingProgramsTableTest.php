<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SendingProgramsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SendingProgramsTable Test Case
 */
class SendingProgramsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SendingProgramsTable
     */
    public $SendingPrograms;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.sending_programs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('SendingPrograms') ? [] : ['className' => SendingProgramsTable::class];
        $this->SendingPrograms = TableRegistry::getTableLocator()->get('SendingPrograms', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SendingPrograms);

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
