<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Voluntario Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property bool $status
 * @property string $firstName
 * @property string $lastName
 * @property \Cake\I18n\FrozenDate $birth
 * @property string $state
 * @property string $residenceCountry
 * @property string $phone
 * @property string $passportNumber
 * @property string $passportCountry
 * @property string $postalCode
 * @property string $spanishLevel
 * @property string $gender
 * @property string $tShirt
 * @property string $emergencyContact
 * @property string $emergencyNumber
 * @property string $dietaryRestrictions
 * @property string $email
 * @property string $allergies
 * @property string $healthConsiderations
 * @property string $middleName
 * @property string $city
 * @property string $address
 */
class Voluntario extends Entity
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
        'created' => true,
        'modified' => true,
        'status' => true,
        'firstName' => true,
        'lastName' => true,
        'birth' => true,
        'state' => true,
        'residenceCountry' => true,
        'phone' => true,
        'passportNumber' => true,
        'passportCountry' => true,
        'postalCode' => true,
        'spanishLevel' => true,
        'gender' => true,
        'tShirt' => true,
        'emergencyContact' => true,
        'emergencyNumber' => true,
        'dietaryRestrictions' => true,
        'email' => true,
        'allergies' => true,
        'healthConsiderations' => true,
        'middleName' => true,
        'city' => true,
        'address' => true,
        
        // For belongsToMany associations, ensure the relevant entity has a property accessible for the associated entity.
        // https://book.cakephp.org/3.0/en/orm/saving-data.html#saving-with-associations
        'brigadas' => true,
    ];
 
    protected function _getFullName()
    {
        return
            $this->_properties['firstName'] 
            . ' ' 
            . $this->_properties['lastName'];
    }
 
}
