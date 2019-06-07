<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Officers Controller
 *
 * @property \App\Model\Table\OfficersTable $Officers
 *
 * @method \App\Model\Entity\Officer[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OfficersController extends AppController
{


    public function beforeFilter($event)
    {
        parent::beforeFilter($event);
        $user = $this->Auth->user();
        if (isset($user['rol']) && $user['rol'] === 'admin' ||
            isset($user['rol']) && $user['rol'] === 'manager' ) {

            $this->Auth->allow();
        }

        return parent::isAuthorized($user);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $officers = $this->paginate($this->Officers);

        $this->set(compact('officers'));
    }

    /**
     * View method
     *
     * @param string|null $id Officer id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $officer = $this->Officers->get($id, [
            'contain' => []
        ]);

        $this->set('officer', $officer);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $officer = $this->Officers->newEntity();
        if ($this->request->is('post')) {
            $officer = $this->Officers->patchEntity($officer, $this->request->getData());
            if ($this->Officers->save($officer)) {
                $this->Flash->success(__('The officer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The officer could not be saved. Please, try again.'));
        }
        $this->set(compact('officer'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Officer id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $officer = $this->Officers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $officer = $this->Officers->patchEntity($officer, $this->request->getData());
            if ($this->Officers->save($officer)) {
                $this->Flash->success(__('The officer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The officer could not be saved. Please, try again.'));
        }
        $this->set(compact('officer'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Officer id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $officer = $this->Officers->get($id);
        if ($this->Officers->delete($officer)) {
            $this->Flash->success(__('The officer has been deleted.'));
        } else {
            $this->Flash->error(__('The officer could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
