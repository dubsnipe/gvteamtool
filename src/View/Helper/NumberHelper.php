<?php 

namespace App\Controller;

use Cake\I18n\Number;

class NumbersController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Auth');
    }

    public function afterLogin()
    {
        $storageUsed = $this->Auth->user('storage_used');
        if ($storageUsed > 5000000) {
            // Notify users of quota
            $this->Flash->success(__('You are using {0} storage', Number::toReadableSize($storageUsed)));
        }
    }
    

}