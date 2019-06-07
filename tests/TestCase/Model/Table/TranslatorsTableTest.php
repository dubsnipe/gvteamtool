<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TranslatorsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TranslatorsTable Test Case
 */
class TranslatorsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TranslatorsTable
     */
    public $Translators;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.translators'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Translators') ? [] : ['className' => TranslatorsTable::class];
        $this->Translators = TableRegistry::getTableLocator()->get('Translators', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Translators);

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
