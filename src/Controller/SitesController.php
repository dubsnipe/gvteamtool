<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class SitesController extends AppController
{
    
    public function initialize()
    {
        parent::initialize();
        // $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); // Include the FlashComponent
    }

    public function beforeFilter($event)
    {
        parent::beforeFilter($event);
        $user = $this->Auth->user();
        if (isset($user['rol']) && $user['rol'] === 'admin' ||
            isset($user['rol']) && $user['rol'] === 'manager' ) {

            $this->Auth->allow(['index', 'view', 'locate']);
        }

        return parent::isAuthorized($user);
    }

    public function index() {
        $sites = $this->paginate($this->Sites);
        $this->set(compact('sites'));
    }


    public function view($id = null)
    {
        $site = $this->Sites->get($id, [
            'contain' => ['Brigadas']
        ]);

        $this->set('site', $site);
    }

    
    public function add()
    {
        $site = $this->Sites->newEntity();
        if ($this->request->is('post')) {
            $site = $this->Sites->patchEntity($site, $this->request->getData());
            if ($this->Sites->save($site)) {
                $this->Flash->success(__('The site has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The site could not be saved. Please, try again.'));
        }
        $this->set(compact('site'));
    }
    
    
    public function edit($id = null)
    {
        $site = $this->Sites->get($id, [
            // 'contain' => ['Brigadas']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $site = $this->Sites->patchEntity($site, $this->request->getData());
            if ($this->Sites->save($site)) {
                $this->Flash->success(__('The site has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The site could not be saved. Please, try again.'));
        }
        $this->set(compact('site'));
    }

    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);

        $site = $this->Sites->findById($id)->firstOrFail();

        if ($this->Sites->delete($site)) {
            $this->Flash->success(__('This site has been deleted: {0}.', $site->name));
            return $this->redirect(['action' => 'index']);
        }
    }

    
}
