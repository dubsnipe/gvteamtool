<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Participaciones Controller
 *
 * @property \App\Model\Table\ParticipacionesTable $Participaciones
 *
 * @method \App\Model\Entity\Participacione[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ParticipacionesController extends AppController
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
        $this->paginate = [
            'contain' => ['Brigadas', 'Voluntarios']
        ];
        $participaciones = $this->paginate($this->Participaciones);

        $this->set(compact('participaciones'));
    }

    /**
     * View method
     *
     * @param string|null $id Participacione id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $participacione = $this->Participaciones->get($id, [
            'contain' => ['Brigadas', 'Voluntarios']
        ]);

        $this->set('participacione', $participacione);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $participacione = $this->Participaciones->newEntity();
        if ($this->request->is('post')) {
            $participacione = $this->Participaciones->patchEntity($participacione, $this->request->getData());
            if ($this->Participaciones->save($participacione)) {
                $this->Flash->success(__('The participacione has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The participacione could not be saved. Please, try again.'));
        }
        $brigadas = $this->Participaciones->Brigadas->find('list', ['limit' => 200]);
        $voluntarios = $this->Participaciones->Voluntarios->find('list', ['limit' => 200]);
        $this->set(compact('participacione', 'brigadas', 'voluntarios'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Participacione id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    // public function edit($id = null)
    // {
        // $participacione = $this->Participaciones->get($id, [
            // 'contain' => []
        // ]);
        // if ($this->request->is(['patch', 'post', 'put'])) {
            // $participacione = $this->Participaciones->patchEntity($participacione, $this->request->getData());
            // if ($this->Participaciones->save($participacione)) {
                // $this->Flash->success(__('The participacione has been saved.'));

                // return $this->redirect(['action' => 'index']);
            // }
            // $this->Flash->error(__('The participacione could not be saved. Please, try again.'));
        // }
        // $brigadas = $this->Participaciones->Brigadas->find('list', ['limit' => 200]);
        // $voluntarios = $this->Participaciones->Voluntarios->find('list', ['limit' => 200]);
        // $this->set(compact('participacione', 'brigadas', 'voluntarios'));
    // }

    public function edit($id)
    {
        $brigada = TableRegistry::getTableLocator()
            ->get('Brigadas')    
            ->findById($id)
            ->contain('Voluntarios')
            ->firstOrFail();
        
        $participacione = $this->Participaciones->find('all');
        // $entities = $articles->newEntities($this->request->getData());
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            // $participacione = $this->Participaciones->patchEntity($participacione, $this->request->getData());
            $participaciones = $this->Participaciones->newEntities($this->request->data());
            foreach ($participaciones as $participacione) {
                $this->Participaciones->save($participacione);
            }
            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('participacione', 'brigada'));
    }

    
    /**
     * Delete method
     *
     * @param string|null $id Participacione id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $participacione = $this->Participaciones->get($id);
        if ($this->Participaciones->delete($participacione)) {
            $this->Flash->success(__('The participacione has been deleted.'));
        } else {
            $this->Flash->error(__('The participacione could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
