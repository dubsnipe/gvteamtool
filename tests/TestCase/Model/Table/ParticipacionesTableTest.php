<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ParticipacionesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ParticipacionesTable Test Case
 */
class ParticipacionesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ParticipacionesTable
     */
    public $Participaciones;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.participaciones',
        'app.brigadas',
        'app.voluntarios'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Participaciones') ? [] : ['className' => ParticipacionesTable::class];
        $this->Participaciones = TableRegistry::getTableLocator()->get('Participaciones', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Participaciones);

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
}
