<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ParticipacionesFixture
 *
 */
class ParticipacionesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'brigada_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'voluntario_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'lider' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
        '_indexes' => [
            'voluntario_key' => ['type' => 'index', 'columns' => ['voluntario_id'], 'length' => []],
            'brigada_key2' => ['type' => 'index', 'columns' => ['brigada_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'brigada_key2' => ['type' => 'foreign', 'columns' => ['brigada_id'], 'references' => ['brigadas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'voluntario_key' => ['type' => 'foreign', 'columns' => ['voluntario_id'], 'references' => ['voluntarios', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'brigada_id' => 1,
                'voluntario_id' => 1,
                'lider' => 1
            ],
        ];
        parent::init();
    }
}
