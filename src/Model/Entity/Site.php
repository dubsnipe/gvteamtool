<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Site Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property string $name
 * @property string $identifier
 * @property string $address
 * @property string $region
 * @property string $area_0
 * @property string $area_1
 * @property string $area_2
 * @property string $area_3
 * @property float $lat
 * @property float $lng
 * @property string $project
 * @property string $telephone
 * @property string $masons
 * @property string $helpers
 * @property string $notes
 * @property int $followup
 * @property \Cake\I18n\FrozenTime $deleted
 */
class Site extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'identifier' => true,
        'region' => true,
        'area_0' => true,
        'area_1' => true,
        'area_2' => true,
        'area_3' => true,
        'lat' => true,
        'lng' => true,
        'project' => true,
        'telephone' => true,
        'masons' => true,
        'helpers' => true,
        'notes' => true,
        'followup' => true,
        'deleted' => true
    ];
}
