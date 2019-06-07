<?php
namespace App\View\Cell;

use Cake\View\Cell;

/**
 * DeletePhoto cell
 */
class DeletePhotoCell extends Cell
{

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Initialization logic run at the end of object construction.
     *
     * @return void
     */
    public function initialize()
    {
    }

    
    /**
     * Default display method.
     *
     * @return void
     */
    public function display($id)
    {
        $user = $this->request->session()->read('Auth');
        
        if (isset($user['User']['rol']) && $user['User']['rol'] === 'admin' ||
            isset($user['User']['rol']) && $user['User']['rol'] === 'manager' ) {
            $this->set('id', $id);
        }else{
            $this->set('id', '0');
        }
    }
}
