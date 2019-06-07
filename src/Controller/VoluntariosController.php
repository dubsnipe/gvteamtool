<?php
// src/Controller/VoluntariosController.php

namespace App\Controller;
use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;

class VoluntariosController extends AppController
{
   
    
    public function initialize()
    {
        parent::initialize();
        
        $this->loadComponent('Security');
        $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); // Include the FlashComponent
        $this->loadComponent('RequestHandler'); // https://stackoverflow.com/questions/44894555/cakephp-3-autocomplete-ajax-responses

    }


    // Tiene elementos extra
    public function beforeFilter($event)
    {
        parent::beforeFilter($event);

        $user = $this->Auth->user();

        if (isset($user['rol']) && $user['rol'] === 'admin' ||
            isset($user['rol']) && $user['rol'] === 'manager' ) {
            $this->Auth->allow(['index', 'view', 'add', 'edit', 'search', 'delete', 'voluntariosAjax', 'emailAjax']);
        }
        
        // Solución alternativa: https://stackoverflow.com/questions/37360734/token-was-not-found-in-request-data-in-cakephp3-after-server-migration
        $this->Security->setConfig('unlockedActions', ['voluntariosAjax', 'emailAjax']);
        
        return parent::isAuthorized($user);
        
    }
    
     public function index()
    {
        
        $voluntarios = $this->Paginator->paginate($this->Voluntarios->find()->order(['firstName', 'lastName']));
        $this->set(compact('voluntarios'));
    }
    

    public function search()
    {
        $queryParams = $this->request->getQueryParams();
        $query = $this->Voluntarios
            ->find('search', ['search' => $this->request->getQueryParams()])
            ->where(['firstName IS NOT' => null])
            ->limit(100);
        
        
        $this->set('voluntarios', $this->paginate($query));
        $this->set('queryParams', $queryParams);
    }

    
    public function searchMany()
    {
        $voluntarios = $this->Voluntarios
        // Use the plugins 'search' custom finder and pass in the
        // processed query params
        ->find('search', ['search' => $this->request->getQueryParams()])
        // You can add extra things to the query if you need to
        ->where(['firstName IS NOT' => null])
        ->limit(50);
        
        $this->set(compact('voluntarios'));
    }
    
    
    public function view($id = null)
    {
        $voluntario = $this->Voluntarios
            ->findById($id)
            ->Contain(['Brigadas'])
            ->firstOrFail();

        $this->set(compact('voluntario'));
    }
    

    public function add()
    {
        $voluntario = $this->Voluntarios->newEntity();
        if ($this->request->is('post')) {
            $voluntario = $this->Voluntarios->patchEntity($voluntario, $this->request->data());
            
            // Hardcoding the user_id is temporary, and will be removed later
            // when we build authentication out.
            // $voluntario->user_id = 1;
            
            if ($this->Voluntarios->save($voluntario)) {
                $this->Flash->success(__('Your team data has been saved.'));
                return $this->redirect(['action' => 'view', $voluntario->id]);
            }
            $this->Flash->error(__('Unable to add your team.'));
        }
        $this->set('voluntario', $voluntario);
    }

    public function addBulk($id)
    {
        $voluntarios = TableRegistry::get('Voluntarios');
        $entities = $voluntarios->newEntities($this->request->getData());
        
        if ($this->request->is('post')) {
            
            foreach ($voluntarios as $voluntario) {
                $oQuery->insert(['id', 'firstName'])
                    ->values ($voluntario); // person array contains name and title
            }
            $oQuery->execute ();
            // $voluntario = $this->Voluntarios->patchEntity($voluntario, $this->request->data());
            // if ($this->Voluntarios->save($voluntario)) {
                // $this->Flash->success(__('Your team data has been saved.'));
                // return $this->redirect(['action' => 'view', $voluntario->id]);
            // }
            $this->Flash->error(__('Unable to add your team.'));
            
        }
        $this->set('voluntarios', $voluntarios);
    }

    
    public function edit($id)
    {
        $voluntario = $this->Voluntarios
            ->findById($id)
            ->contain(['Brigadas'])
            ->firstOrFail();
        
        // $voluntario2 = $this->Voluntarios->Brigadas->find('list', [
                    // 'conditions' => ['Participaciones.voluntario_id' => $id], 
                    // 'fields' => ['Brigadas.id',],
                // ]);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            // return debug($this->request->data);
            
            $associated = ['Brigadas'];
            $this->Voluntarios->patchEntity($voluntario, $this->request->data, ['associated' => $associated]);

            // return debug($voluntario);            
            
            if ($this->Voluntarios->save($voluntario)) {
                $this->Flash->success(__('Your team data has been updated.'));
                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('Unable to update your team data.'));
        }
   
   // Get a list.
        $brigadas = $this->Voluntarios->Brigadas->find('list');
        $brigadas = $this->Voluntarios->Brigadas->find('list', [
                                                            'valueField' => function ($row) {
                                                                                return $row['name'] . ' ' . $row['arrival'];
                                                                            }
                                                            ]);
        
        // Set tags to the view context
        // $this->set('brigadas', $brigadas);
        
        $this->set('voluntario', $voluntario);
        // $this->set('voluntario2', $voluntario2);
    }
    
    
    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);

        $voluntario = $this->Voluntarios->findById($id)->firstOrFail();
        if ($this->Voluntarios->delete($voluntario)) {
            $this->Flash->success(__('The voluntario: {0} has been deleted.', $voluntario->full_name));
            return $this->redirect(['action' => 'index']);
        }
    }

    // http://www.naidim.org/cakephp-3-tutorial-18-autocomplete
    // No está funcionando
    public function getAllVoluntarios()
    {
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            
            $name = $this->request->query['term'];
            return debug($name);
            $results = $this->Voluntarios->find('all', [
                'conditions' => [
                    'OR' => [
                        'firstName LIKE' => $name . '%',
                        'middleName LIKE' => $name . '%',
                        'lastName LIKE' => $name . '%',
                    ],
                ]
            ]);
            $resultsArr = [];
            foreach ($results as $result) {
                 $resultsArr[] =['label' => $result['firstName'] . $result['lastName'], 'value' => $result['id']];
            }
            echo json_encode($resultsArr);
        }
    }
    
    public function voluntariosAjax()
    {
        if ($this->request->is('ajax')) {
            
            $name = $this->request->data['full_name'];
            $results = $this->Voluntarios->find('all', [
                'conditions' => [
                    'OR' => [
                        'concat(firstName, " ", middleName, " ", lastName) LIKE' => '%' . $name . '%',
                        'concat(firstName, " ", lastName) LIKE' => '%' . $name . '%',
                    ],
                ]
            ])->limit(20);            
            
            $volResultsArr = [];
            foreach ($results as $result) {
                 $volResultsArr[] = [
                                        'id' => $result['id'],
                                        'full_name' => $result['firstName'] . " " . $result['lastName']
                                    ];
            }
        
        $this->set('volResultsArr', $volResultsArr);
        // This line is what handles converting your array into json
        // To get this to work you must load the request handler
         $this->set('_serialize', 'volResultsArr');
         
        }
    }
   
    public function emailAjax()
    {
        if ($this->request->is('ajax')) {
            $email = $this->request->data['email'];
            $results = $this->Voluntarios->find('all', [
                'conditions' => [
                    'email LIKE' => '%' . $email . '%',
                ]
            ]);            
            
            $resultsArr = [];
            foreach ($results as $result) {
                 $resultsArr[] = $result['email'];
            }
        
        $this->set('resultsArr', $resultsArr);
        // This line is what handles converting your array into json
        // To get this to work you must load the request handler
         $this->set('_serialize', 'resultsArr');
        }
    }
   
    
}