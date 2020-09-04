<?php
declare(strict_types=1);

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

use Cake\Event\Event;
use Cake\Auth\DefaultPasswordHasher;

use Cake\Event\EventInterface;
use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;
use Cake\Datasource\ConnectionManager;
use DateTime;
use Cake\Routing\Router;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\View\Helper\UrlHelper;


class UsersController extends AppController
{	
	public function initialize():void
	{
		parent::initialize();
		//$this->connection = ConnectionManager::get('default');
	} 
	public function view()
    {
		
        $usersTable = $this->getTableLocator()->get('users');

		$query = $usersTable->find();
		$this->set('users',$query);
		
    }
	public function add(){
		if($this->request->is('post')){
			$username = $this->request->getData('username');
			$email = $this->request->getData('email');
			$status = $this->request->getData('status');
			$hashPswdObj = new DefaultPasswordHasher;
			$password = $hashPswdObj->hash($this->request->getData('password'));
			
			
			$usersTable = $this->getTableLocator()->get('users');
			$user = $usersTable->newEmptyEntity();

			$user->username = $username;
			$user->password = $password;
			$user->email = $email;
			$user->status = $status;
			$user->insert_time = new DateTime('now');

			if ($usersTable->save($user)) {
				echo $new_id = $user->id;
				$this->redirect('/users');
			}else{
				
			}
			
			/*$o = array(
				'username' => $username,
				'password' => $password,
				'email' => $email,
				'status' => $status,
				'insert_time' => new DateTime('now')
			);
			
			$insertstatus = $this->connection->insert('users', $o, ['insert_time' => 'datetime']);
			
			if($insertstatus)
				$this->redirect('/users');
			else
				echo "Error in adding user.";*/
		}
	}
	public function api(){
		$usersTable = $this->getTableLocator()->get('users');

		$query = $usersTable->find();
		
		$users = array();
		foreach ($query as $row) {
			
			$users[] = (object)array('username'=>$row->username, 'email'=>$row->email, 'status'=>$row->status, 'time'=>$row->insert_time);
		}
		
		exit(json_encode($users));
	}
}
