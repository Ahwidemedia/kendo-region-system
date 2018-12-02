<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\I18n\Time;



class AppController extends Controller
{



    public function initialize()
    {
    parent::initialize();
    	$this->loadComponent('Csrf');
   	    $this->loadComponent('Security');
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
        'authorize' => ['Controller'], 
            'loginRedirect' => [
                'controller' => 'Pages',
                'action' => 'index',
                'prefix' => false
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login',
                'prefix' => false
                
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login',
                'prefix' => false,
            ],
            'authError' => 'Vous devez être identifié pour pouvoir accéder à cette section.',
        ]);
   
   
     
  if($this->Auth->User('id') !== null) {
  $this->loadModel('Users');
  
  $user_id = $this->Auth->User('id');
  
 $user = $this->Users->find('all')
 ->where(['Users.id'=>$user_id])
 ->contain('Clubs')
 ->first();
 
 $this->set('user',$user);
 
  }
   
   
   }
    

    
   
   public function isAuthorized($user) {

    // Admin peuvent accéder à chaque action
   if (isset($user['role']) && $user['role'] === 'Admin') {

     return true;
   }
    

  //  elseif ((isset($user['role']) && ($user['role'] === 'Membre')) OR (isset($user['role']) && ($user['role'] === 'Premium'))) {
    
      if (empty($this->request->params['prefix'])) {
            return true;
        }

        // Seulement les administrateurs peuvent accéder aux fonctions d'administration
        if ($this->request->params['prefix'] === 'admin') {
            return (bool)($user['role'] === 'admin');
        }

        // Par défaut n'autorise pas
        return false;
    
			
		
  //  }
}
     
    
}
