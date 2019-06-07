<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Participacione Entity
 *
 * @property int $id
 * @property int $brigada_id
 * @property int $voluntario_id
 * @property bool $lider
 *
 * @property \App\Model\Entity\Brigada $brigada
 * @property \App\Model\Entity\Voluntario $voluntario
 */
class Participacione extends Entity
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
        'brigada_id' => true,
        'voluntario_id' => true,
        'lider' => true,
        'brigada' => true,
        'voluntario' => true
    ];
}
