<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * SendingPrograms Controller
 *
 * @property \App\Model\Table\SendingProgramsTable $SendingPrograms
 *
 * @method \App\Model\Entity\SendingProgram[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SendingProgramsController extends AppController
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
        $sendingPrograms = $this->paginate($this->SendingPrograms);

        $this->set(compact('sendingPrograms'));
    }

    /**
     * View method
     *
     * @param string|null $id Sending Program id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $sendingProgram = $this->SendingPrograms->get($id, [
            'contain' => []
        ]);

        $this->set('sendingProgram', $sendingProgram);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $sendingProgram = $this->SendingPrograms->newEntity();
        if ($this->request->is('post')) {
            $sendingProgram = $this->SendingPrograms->patchEntity($sendingProgram, $this->request->getData());
            if ($this->SendingPrograms->save($sendingProgram)) {
                $this->Flash->success(__('The sending program has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sending program could not be saved. Please, try again.'));
        }
        $this->set(compact('sendingProgram'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Sending Program id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $sendingProgram = $this->SendingPrograms->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sendingProgram = $this->SendingPrograms->patchEntity($sendingProgram, $this->request->getData());
            if ($this->SendingPrograms->save($sendingProgram)) {
                $this->Flash->success(__('The sending program has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sending program could not be saved. Please, try again.'));
        }
        $this->set(compact('sendingProgram'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Sending Program id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sendingProgram = $this->SendingPrograms->get($id);
        if ($this->SendingPrograms->delete($sendingProgram)) {
            $this->Flash->success(__('The sending program has been deleted.'));
        } else {
            $this->Flash->error(__('The sending program could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
