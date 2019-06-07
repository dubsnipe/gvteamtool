<?php
// src/Model/Entity/Brigada.php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Collection\Collection;

class Brigada extends Entity
{
    
    protected $_accessible = [
        '*' => true,
        'id' => false,
        'tag_string' => true,
        '_joinData ' => true,
        'dir' => true,
        'photo' => true,
    ];
    
    
    protected function _getTagString()
    {
        if (isset($this->_properties['tag_string'])) {
            return $this->_properties['tag_string'];
        }
        if (empty($this->tags)) {
            return '';
        }
        $tags = new Collection($this->tags);
        $str = $tags->reduce(function ($string, $tag) {
            return $string . $tag->title . ', ';
        }, '');
        return trim($str, ', ');
    }
    

}
