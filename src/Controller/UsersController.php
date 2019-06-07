<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Utility\Security;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{


    public function beforeFilter($event)
    {
        parent::beforeFilter($event);
        
        $user = $this->Auth->user();
        if (isset($user['rol']) && $user['rol'] === 'admin') {
            $this->Auth->allow(['index', 'add', 'view', 'edit', 'delete']);
        }elseif(isset($user['rol']) && $user['rol'] === 'manager'){
            $this->Auth->allow(['index', 'view']);
        }else{
            return false;
        };

        return parent::isAuthorized($user);
    }
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }
    
    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        $this->set('user', $user);
    }

    
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    
    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    // https://book.cakephp.org/3.0/en/tutorials-and-examples/cms/authentication.html
    // https://github.com/Nishi1/Cakephp-3.x-remember-me-Login-functionality
    public function login()
    {        
        // Original login function
        // if ($this->request->is('post')) {
            // $user = $this->Auth->identify();
            // if ($user) {
                // $this->Auth->setUser($user);
                // return $this->redirect($this->Auth->redirectUrl());
            // }
            // $this->Flash->error('Your username or password is incorrect.');
        // }

    // https://github.com/Nishi1/Cakephp-3.x-remember-me-Login-functionality
    // Add 'remember_token' to Users table
    // $this->viewBuilder()->setLayout('users\login');
    
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                if (isset($this->request->getData()['xx'])) {
                    $user_id = $this->Auth->user('id');										
                    $this->Cookie->write('hooty_remembertoken', $this->encryptpass($this->request->data['email'])."^".base64_encode($this->request->data['password']), true);
                    $user = $this->Users->get($user_id);
                    $user->remember_token = $this->encryptpass($this->request->data['email']);
                    $this->Users->save($user);													
                    unset($this->request->getData()['xx']);
                }
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Flash->error(__('Username or password is incorrect'));
                $this->redirect(['controller' => 'Stats', 'action' => 'index']);
            }
        } elseif(empty($this->data)) {			
            $hooty_remembertoken = $this->Cookie->read('hooty_remembertoken');			
            if (!is_null($hooty_remembertoken)) {
                $hooty_remembertoken = explode("^",$hooty_remembertoken);							
                $data = $this->Users->find('all', ['conditions' => ['remember_token'=>$hooty_remembertoken[0]]], ['fields'=>['email','password']])->first();
                $this->request->data['email'] = $data->email;
                $this->request->data['password'] = base64_decode($hooty_remembertoken[1]);		
                $user = $this->Auth->identify();
                if ($user) {
                    $this->Auth->setUser($user);
                    $this->redirect($this->Auth->redirectUrl());					
                } else {
                    $this->redirect(['controller' => 'Stats', 'action' => 'index']);
                }
            }
        }
    }


    
    public function logout()
    {
        // https://github.com/Nishi1/Cakephp-3.x-remember-me-Login-functionality        
        $this->Auth->logout();
        $this->request->session()->destroy();

        // Esta es la cookie que debe borrarse, la de remember me.
        $this->Cookie->delete('hooty_remembertoken');
        
        $this->Flash->success(__('You are now logged out'));
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }
    
    
    private function encryptpass($password,$method = 'md5',$crop = true,$start = 4, $end = 10){
        if($crop){
            $password = $method(substr($method($password),$start,$end));
        }else{
            $password = $method($password);
        }
        return $password;
    }

    
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['logout']);
        
        // Add the 'add' action to the allowed actions list.
        $this->Auth->allow(['logout']);
        
        // Original. Eliminé para no permitir hacer usuarios nuevos por el momento.
        // $this->Auth->allow(['logout' , 'add']);
        
        // $this->addBehavior('Acl.Acl', ['controlled']);
    }
    
    
}
