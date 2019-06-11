<?php
// src/Controller/echo.php

namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

// https://book.cakephp.org/3.0/en/tutorials-and-examples/blog-auth-example/auth.html
// https://stackoverflow.com/questions/40118473/cakephp-3-3-how-to-allow-access-different-user-roles-to-different-methods-in-c
use Cake\Event\Event;

class BrigadasController extends AppController
{


    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); // Include the FlashComponent
        $this->loadComponent('RequestHandler');
    }
    
    
    public function beforeFilter($event)
    {
        parent::beforeFilter($event);
        
        $user = $this->Auth->user();

        if (isset($user['rol']) && $user['rol'] === 'admin' ||
            isset($user['rol']) && $user['rol'] === 'manager' ) {
            $this->Auth->allow(['index', 'view', 'add', 'addVolunteers', 'addLeaders', 'addVolunteersTo', 'edit', 'search', 'delete', 'brigadasAjax', 'locate']);
        }

        // Solución alternativa: https://stackoverflow.com/questions/37360734/token-was-not-found-in-request-data-in-cakephp3-after-server-migration
        $this->Security->setConfig('unlockedActions', ['brigadasAjaxDos']);
        
        return parent::isAuthorized($user);
    }

    
     public function index()
    {
        $brigadas = $this->Paginator->paginate(
            $this->Brigadas
                ->find()
                ->contain(['Voluntarios'])
                ->order([
                'Brigadas.arrival' => 'desc', 
                'Brigadas.name' => 'desc',
                ])
        );
        
        $this->set(compact('brigadas'));
        
    }

    
    public function search()
    {
        $queryParams = $this->request->getQueryParams();
        if (isset($this->request->getQueryParams()['status']) and $this->request->getQueryParams()['status'] == 'on') {
                $status = 1;
        } else {
                $status = 0;
        };
        
        if ($status == 1){
            $query = $this->Brigadas
                ->find('search', ['search' => $this->request->getQueryParams()])
                ->where([
                        'name IS NOT' => null,
                        'status' => 1,
                        ])
                ->order(['arrival' => 'ASC']);
                // ->limit(100);
        } else {
            $query = $this->Brigadas
                ->find('search', ['search' => $this->request->getQueryParams()])
                ->where([
                        'name IS NOT' => null,
                        ])
                ->order(['arrival' => 'ASC']);
                // ->limit(100);    
        }
        
        $this->set('brigadas', $this->paginate($query));
        $this->set('queryParams', $queryParams);
    }

    
    public function view($id = null)
    {
        $brigada = $this->Brigadas->findById($id)->contain(['Tags','Voluntarios'])->firstOrFail();

        $this->set('brigada', $brigada);
        // $this->set(compact('brigada', 'tags'));

    }
    

    public function add()
    {
        $brigada = $this->Brigadas->newEntity();                                
            
        $types = TableRegistry::getTableLocator()->get('Types');
        $typeChoices = $types->find('list', ['keyField' => 'title', 'valueField' => 'title']);
        
        $regions = TableRegistry::getTableLocator()->get('Regions');
        $regionChoices = $regions->find('list', ['keyField' => 'title', 'valueField' => 'title']);
        
        $officers = TableRegistry::getTableLocator()->get('Officers');
        $officerChoices = $officers->find('list', ['keyField' => 'name', 'valueField' => 'name']);
        
        $translators = TableRegistry::getTableLocator()->get('Translators');
        $translatorChoices = $translators->find('list', ['keyField' => 'name', 'valueField' => 'name']);

        $projects = TableRegistry::getTableLocator()->get('Projects');
        $projectChoices = $projects->find('list', ['keyField' => 'name', 'valueField' => 'name']);
        
        if ($this->request->is('post')) {
            $brigada = $this->Brigadas->patchEntity($brigada, $this->request->getData());

        // Hardcoding the user_id is temporary, and will be removed later
        // when we build authentication out.
        $brigada->user_id = 1;
            
        if ($this->Brigadas->save($brigada)) {
            
            if (isset($this->request->data['addVolunteers'])) {
                return $this->redirect(['action' => 'addVolunteers', $brigada->id]);
            } else {
                $this->Flash->success(__('Your team data has been saved.'));
                return $this->redirect(['action' => 'view', $brigada->id]);
            }
            
        }
        
        $this->Flash->error(__('Unable to add your team.'));
    }

        $this->set('brigada', $brigada);
        $this->set('typeChoices', $typeChoices);
        $this->set('regionChoices', $regionChoices);
        $this->set('projectChoices', $projectChoices);
        $this->set('officerChoices', $officerChoices);
        $this->set('translatorChoices', $translatorChoices);
    }


    public function addVolunteers($id)
    {  
        $brigada = $this->Brigadas
            ->findById($id)
            ->contain(['Voluntarios'])
            ->firstOrFail();
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            if (!empty($this->request->data['voluntarios']['_ids'])) {
                $vol = [];
                foreach ($this->request->data['voluntarios']['_ids'] as $key=>$locationId) {
                    $vol[] = [
                        'id' => $locationId,
                        '_joinData' => [
                            'lider' => isset($this->request->data['voluntarios'][$key]['_joinData']['lider']) ? $this->request->data['voluntarios'][$key]['_joinData']['lider'] : false
                        ]
                    ];
                }
            }
            if (isset($vol)){                
                $this->request->data['voluntarios'] = $vol;
            }
            
            $this->Brigadas->patchEntity($brigada, $this->request->getData());
            
            if ($this->Brigadas->save($brigada)) {
            
            if (isset($this->request->data['addLeaders'])) {
                return $this->redirect(['action' => 'addLeaders', $brigada->id]);
            } else {
                $this->Flash->success(__('Your team data has been saved.'));
                return $this->redirect(['action' => 'view', $brigada->id]);
            }
            
        }
            $this->Flash->error(__('Unable to update your team data.'));
        }
        
        $voluntarios = $this->Brigadas->Voluntarios->find('list', [
                                                            'valueField' => function ($row) {
                                                                                return $row['full_name'];
                                                                            }
                                                            ]);

        
        $this->set('voluntarios', $voluntarios);
        $this->set('brigada', $brigada);

    }

    
    public function addLeaders($id)
    {
        
        $brigada = $this->Brigadas
            ->findById($id)
            ->contain(['Voluntarios'])
            ->firstOrFail();
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            if (!empty($this->request->data['voluntarios']['_ids'])) {
                $vol = [];
                foreach ($this->request->data['voluntarios']['_ids'] as $key=>$locationId) {
                    $vol[] = [
                        'id' => $locationId,
                        '_joinData' => [
                            'lider' => isset($this->request->data['voluntarios'][$key]['_joinData']['lider']) ? $this->request->data['voluntarios'][$key]['_joinData']['lider'] : false
                        ]
                    ];
                }
            }
            if (isset($vol)){                
                $this->request->data['voluntarios'] = $vol;
            }
            
            $this->Brigadas->patchEntity($brigada, $this->request->getData());
            
            if ($this->Brigadas->save($brigada)) {
            
                if (isset($this->request->data['addLeaders'])) {
                    return $this->redirect(['action' => 'addLeaders', $brigada->id]);
                } else {
                    $this->Flash->success(__('Your team data has been saved.'));
                    return $this->redirect(['action' => 'view', $brigada->id]);
                }
            
            }
            $this->Flash->error(__('Unable to update your team data.'));
        }
        
        $voluntarios = $this->Brigadas->Voluntarios->find('list', [
                                                            'valueField' => function ($row) {
                                                                                return $row['full_name'];
                                                                            }
                                                            ]);

        
        $this->set('voluntarios', $voluntarios);
        $this->set('brigada', $brigada);

    }

    
    public function addVolunteersTo($id)
    {
        
        $brigada = $this->Brigadas
            ->findById($id)
            ->contain(['Voluntarios'])
            ->firstOrFail();
        
        $voluntarios = TableRegistry::getTableLocator()->get('Voluntarios');
        $voluntario = $voluntarios->newEntity();
        
        if ($this->request->is('post')) {
            
            $voluntario = $voluntarios->patchEntity($voluntario, $this->request->data());
                        
            if ($voluntarios->save($voluntario)) {
                
                $this->Brigadas->Voluntarios->link($brigada, [$voluntario]);
                // $brigada->voluntarios[] = $voluntario;

                if ($this->Brigadas->save($brigada)) {
                    
                    if (isset($this->request->data['addAnother'])) {
                        return $this->redirect(['action' => 'addVolunteersTo', $brigada->id]);
                    } else {
                        $this->Flash->success(__('Your team data has been saved.'));
                        return $this->redirect(['action' => 'view', $brigada->id]);
                    }
                    
                    
                    $this->Flash->success(__('Your team data has been saved.'));
                    return $this->redirect(['action' => 'view', $brigada->id]);
                }
                
            }
            $this->Flash->error(__('Unable to add your team.'));
        }
        $this->set('voluntario', $voluntario);
        $this->set('brigada', $brigada);

    }


    public function edit($id)
    {
        
        $brigada = $this->Brigadas
            ->findById($id)
            ->contain(['Tags', 'Voluntarios']) // load associated Voluntarios
            ->firstOrFail();
        
        $types = TableRegistry::getTableLocator()->get('Types');
        $typeChoices = $types->find('list', ['keyField' => 'title', 'valueField' => 'title']);
        
        $regions = TableRegistry::getTableLocator()->get('Regions');
        $regionChoices = $regions->find('list', ['keyField' => 'title', 'valueField' => 'title']);
        
        $officers = TableRegistry::getTableLocator()->get('Officers');
        $officerChoices = $officers->find('list', ['keyField' => 'name', 'valueField' => 'name']);
        
        $translators = TableRegistry::getTableLocator()->get('Translators');
        $translatorChoices = $translators->find('list', ['keyField' => 'name', 'valueField' => 'name']);

        $projects = TableRegistry::getTableLocator()->get('Projects');
        $projectChoices = $projects->find('list', ['keyField' => 'name', 'valueField' => 'name']);
        
        $sendingPrograms = TableRegistry::getTableLocator()->get('SendingPrograms');
        $sendingProgramChoices = $sendingPrograms->find('list', ['keyField' => 'name', 'valueField' => 'name']);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            // return debug($this->request->data);
            // https://github.com/cakephp/cakephp/issues/7864
            
            // if (!empty($this->request->data['voluntarios']['_ids'])) {
                // $vol = [];
                // foreach ($this->request->data['voluntarios']['_ids'] as $key=>$locationId) {
                    // $vol[] = [
                        // 'id' => $locationId,
                        // '_joinData' => [
                            // 'lider' => isset($this->request->data['voluntarios'][$key]['_joinData']['lider']) ? $this->request->data['voluntarios'][$key]['_joinData']['lider'] : false
                        // ]
                    // ];
                // }
            // }
            // if (isset($vol)){                
                // $this->request->data['voluntarios'] = $vol;
            // }
            
            $this->Brigadas->patchEntity($brigada, $this->request->getData());
            // return debug($brigada['voluntarios']);
            // https://stackoverflow.com/questions/37162154/cakephp-3-saving-data-to-a-join-table-and-a-table-associated-to-that-join-table?rq=1

            // if ($this->Brigadas->save($brigada)) {
                // $this->Flash->success(__('Your team data has been updated.'));
                // return $this->redirect(['action' => 'view', $id]);
            // }
            
            if ($this->Brigadas->save($brigada)) {
            
                if (isset($this->request->data['addLeaders'])) {
                    return $this->redirect(['action' => 'addLeaders', $brigada->id]);
                } else {
                    $this->Flash->success(__('Your team data has been saved.'));
                    return $this->redirect(['action' => 'view', $brigada->id]);
                }
            
            }
            
            $this->Flash->error(__('Unable to update your team data.'));
        }
        
        $tags = $this->Brigadas->Tags->find('list');

        // $this->set('participaciones', $this->Brigadas->Participaciones->find('list', [
            // 'keyField' => 'id', 
            // 'valueField' => 'name'
        // ]));
        
        // Get a list of volunteers.
        $voluntarios = $this->Brigadas->Voluntarios->find('list', [
                                                            'valueField' => function ($row) {
                                                                                return $row['full_name'];
                                                                            }
                                                            ]);

        
        // Set to the view context
        $this->set('tags', $tags);
        $this->set('voluntarios', $voluntarios);
        $this->set('brigada', $brigada);
        
        $this->set('typeChoices', $typeChoices);
        $this->set('regionChoices', $regionChoices);
        $this->set('projectChoices', $projectChoices);
        $this->set('officerChoices', $officerChoices);
        $this->set('translatorChoices', $translatorChoices);
        
    }


    public function locate($id)
    {
        $brigada = $this->Brigadas
            ->findById($id)
            ->firstOrFail();

        if ($this->request->is(['patch', 'post', 'put'])) {

            $this->Brigadas->patchEntity($brigada, $this->request->getData);

            if ($this->Brigadas->save($brigada)) {
                $this->Flash->success(__('Your team data has been updated.'));
                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('Unable to update your team data.'));
        }
        
        
        $this->set('brigada', $brigada);        

    }



    // No está en funcionamiento. Opción con ajax:
    // https://stackoverflow.com/questions/15071975/how-can-i-delete-files-with-cakephp-and-ajax
    // public function deletePhoto() {
        // return debug($this->request->data)
        // $imgName = $this->request->data['imgName'];
        // $itemId = $this->request->data['itemId'];
        // /**
         // * Where is the $dir below actually set? Make sure to pass it properly!
         // * Furthermore, it's always cleaner to use DS constant
         // * (short for DIRECTORY_SEPARATOR), so the code will work on any OS
         // */
        // $file = new File($dir . DS . $itemId . DS . $imgName);
        // return $file->delete();
    // } 


    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);

        $brigada = $this->Brigadas->findById($id)->firstOrFail();

        if ($this->Brigadas->delete($brigada)) {
            $this->Flash->success(__('This team has been deleted: {0}.', $brigada->name));
            return $this->redirect(['action' => 'index']);
        }
    }

    public function deletePhoto($id)
    {
        
        // https://stackoverflow.com/questions/54946480/my-update-function-doesnt-set-values-to-null-after-saving/55215037#55215037
        $query = $this->Brigadas->query();
        $query->update()
            ->set([
                    'dir' => null,
                    'photo' => null,
                 ])
            ->where(['id' => $id])
            ->execute();
            
        $this->Flash->success(__('The team photo has been deleted'));
        return $this->redirect(['action' => 'view', $id]);
        
    }

    
    public function tags()
    {
        // https://book.cakephp.org/3.0/en/tutorials-and-examples/cms/tags-and-users.html
        // The 'pass' key is provided by CakePHP and contains all
        // the passed URL path segments in the request.
        $tags = $this->request->getParam('pass');

        // Use the ArticlesTable to find tagged articles.
        $brigadas = $this->Brigadas->find('tagged', [
            'tags' => $tags
        ]);

        // Pass variables into the view template context.
        $this->set([
            'brigadas' => $brigadas,
            'tags' => $tags
        ]);
    }

    
    public function brigadasAjax()
    {
        if ($this->request->is('ajax')) {
            $name = $this->request->data['brigadasAjax'];
            
            $results = $this->Brigadas->find('all', [
                'conditions' => [
                    'OR' => [
                        'name LIKE' => '%' . $name . '%',
                    ],
                ]
            ]);            
            
            $resultsArr = [];
            foreach ($results as $result) {
                 
                 $resultsArr[] = $result['name'] . " : " . $result['arrival'] . ' - ' . $result['departure'];
            }
        
        $this->set('resultsArr', $resultsArr);
        // This line is what handles converting your array into json
        // To get this to work you must load the request handler
         $this->set('_serialize', 'resultsArr');
        }
    }
   
    public function brigadasAjaxDos()
    {
        if ($this->request->is('ajax')) {
            $name = $this->request->data['name'];
            
            $results = $this->Brigadas->find('all', [
                'conditions' => [
                    'OR' => [
                        'name LIKE' => '%' . $name . '%',
                    ],
                ]
            ]);            
            
            $resultsArr = [];
            foreach ($results as $result) {
                 
                 $resultsArr[] = [
                                        'id' => $result['id'],
                                        'name' => $result['name'],
                                        // 'date' => $result['arrival'] . ' - ' . $result['departure']
                 ];
            }
        
        $this->set('resultsArr', $resultsArr);
        // This line is what handles converting your array into json
        // To get this to work you must load the request handler
         $this->set('_serialize', 'resultsArr');
        }
    }    

}
