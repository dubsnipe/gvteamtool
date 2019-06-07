<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Controller\Component\CookieComponent;
use Cake\Event\Event;

// use Cake\I18n\Number;

// https://stackoverflow.com/questions/27728798/authorization-and-acl-in-cakephp-3
// use Acl\Controller\Component\AclComponent;
// use Cake\Controller\ComponentRegistry;


class AppController extends Controller
{

    /**
     * Initialization hook method.
     * Use this method to add common initialization code like loading components.
     * e.g. `$this->loadComponent('Security');`
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        /*
         * Enable the following components for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         * https://stackoverflow.com/questions/15704600/cakephp-security-component-blackholing-login-data-tokenkey-field-not-genera
         */
        $this->loadComponent('Security');
        $this->loadComponent('Csrf');
        
        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        
        $this->loadComponent('Flash');
        $this->loadComponent('Cookie');

        $this->loadComponent('Auth', [
            'authorize' => ['Controller'], // Added this line - https://book.cakephp.org/3.0/en/tutorials-and-examples/blog-auth-example/auth.html  
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password'
                    ]
                ]
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
             // If unauthorized, return them to page they were just on
            'unauthorizedRedirect' => $this->referer()
        ]);

        // Allow the display action so our PagesController
        // continues to work. Also enable the read only actions.
        $this->Auth->allow(['display']);
        $this->Auth->user(['id', 'username']);
        
     
    }
    
    
    public function isAuthorized($user = null)
    {
        // throw new ForbiddenException(__('You are not authorized to access.'));
        return false;
        // parent::isAuthorized ();
    }
 
 // https://stackoverflow.com/questions/9507485/isauthorized-redirect-url-cakephp
}