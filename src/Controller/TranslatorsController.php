<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Translators Controller
 *
 * @property \App\Model\Table\TranslatorsTable $Translators
 *
 * @method \App\Model\Entity\Translator[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TranslatorsController extends AppController
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
        $translators = $this->paginate($this->Translators);

        $this->set(compact('translators'));
    }

    /**
     * View method
     *
     * @param string|null $id Translator id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $translator = $this->Translators->get($id, [
            'contain' => []
        ]);

        $this->set('translator', $translator);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $translator = $this->Translators->newEntity();
        if ($this->request->is('post')) {
            $translator = $this->Translators->patchEntity($translator, $this->request->getData());
            if ($this->Translators->save($translator)) {
                $this->Flash->success(__('The translator has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The translator could not be saved. Please, try again.'));
        }
        $this->set(compact('translator'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Translator id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $translator = $this->Translators->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $translator = $this->Translators->patchEntity($translator, $this->request->getData());
            if ($this->Translators->save($translator)) {
                $this->Flash->success(__('The translator has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The translator could not be saved. Please, try again.'));
        }
        $this->set(compact('translator'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Translator id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $translator = $this->Translators->get($id);
        if ($this->Translators->delete($translator)) {
            $this->Flash->success(__('The translator has been deleted.'));
        } else {
            $this->Flash->error(__('The translator could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
