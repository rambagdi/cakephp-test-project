<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\AppController;

use Cake\Utility\Hash;

use Cake\Http\ServerRequest;


class ApiUsersController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('Users');
    }
    
    public function login()
    {
    	    $this->loadComponent('Authentication.Authentication');	
	    $result = $this->Authentication->getResult();
	    // If the user is logged in send them away.
	    if ($result->isValid()) {
		$user = $result->getData();
		if($user->id){
			
		}
		if (!empty($user)) {
		    $auth_token = $this->generate_token();
		    
		    $user->token = $auth_token;
		    if ($this->Users->save($user)) {
		        // success response
		        $status = true;
		        $message = 'User has been updated';
		    } else {
		        // error response
		        $status = false;
		        $message = 'Failed to update user';
		    }
		} else {
		    // user not found
		    $status = false;
		    $message = 'Article Not Found';
		}
	    }else{
		$this->response = $this->response->withStatus(401);
		$user = [
			'message' => 'invailid user'
		];
	    }
	    $this->set('user',$user);
	    $this->viewBuilder()->setOption('serialize', 'user');
    }
    
     /**
     * Logs a user out.
     *
     * @return \Cake\Http\Response|null
     */
    public function logout()
    {
        $header = $this->request->getHeaders();
        if(!$this->verifyToken($header)){
		$this->set([
		    'status' => false,
		    'message' => 'Invalid token',
		]);
		$this->viewBuilder()->setOption('serialize', ['status', 'message']);
		return;
        }else{
		$articleData = $this->Users->find()->where([
		    'token' => $header['Access-Token'][0]
		])->first();

		if (!empty($articleData)) {
		    $articleData->token = $this->generate_token();
		    $this->Users->save($articleData);
		    $status = false;
		    $message = 'User already exists';
		}
		
		$user = [
			'message' => 'You successfully logged out.'
		];
	    
	    $this->set('user',$user);
	    $this->viewBuilder()->setOption('serialize', 'user');
	 }   
    }
    
    public function add()
    {
        $this->request->allowMethod(['post']);

        // form data
        $formData = $this->request->getData();

        // email check rules
        $articleData = $this->Users->find()->where([
            'email' => $formData['email']
        ])->first();

        if (!empty($articleData)) {
            // already exists
            $status = false;
            $message = 'User already exists';
        } else {
            // insert new user
	    $auth_token = $this->generate_token();
	    
            $articleObject = $this->Users->newEmptyEntity();
            
	    $articleObject->token = $auth_token;	
            $articleObject = $this->Users->patchEntity($articleObject, $formData);

            if ($this->Users->save($articleObject)) {
                // success response
                $status = true;
                $message = 'User has been created';
            } else {
                // error response
                $status = false;
                $message = 'Failed to create user';
            }
        }
        $this->set([
            'status' => $status,
            'message' => $message
        ]);

        $this->viewBuilder()->setOption('serialize', ['status', 'message']);
    }
	
    public function index()
    {
        $header = $this->request->getHeaders();
        if(!$this->verifyToken($header)){
		$this->set([
		    'status' => false,
		    'message' => 'Invalid token',
		]);
		$this->viewBuilder()->setOption('serialize', ['status', 'message']);
		return;
        }
        $this->request->allowMethod(['get']);

        $users = $this->Users->find()->toList();

        $this->set([
            'status' => true,
            'message' => 'Users list',
            'data' => $users
        ]);

        $this->viewBuilder()->setOption('serialize', ['status', 'message', 'data']);
    }	
	
    public function edit()
    {
        $header = $this->request->getHeaders();
        if(!$this->verifyToken($header)){
		$this->set([
		    'status' => false,
		    'message' => 'Invalid token',
		]);
		$this->viewBuilder()->setOption('serialize', ['status', 'message']);
		return;
        }
        $this->request->allowMethod(['put', 'post']);

        $user_id = $this->request->getParam('id');

        $userInfo = $this->request->getData();

        // user check
        $user = $this->Users->get($user_id);

        if (!empty($user)) {
            // user exists
            $user = $this->Users->patchEntity($user, $userInfo);

            if ($this->Users->save($user)) {
                // success response
                $status = true;
                $message = 'User has been updated';
            } else {
                // error response
                $status = false;
                $message = 'Failed to update user';
            }
        } else {
            // user not found
            $status = false;
            $message = 'Article Not Found';
        }

        $this->set([
            'status' => $status,
            'message' => $message
        ]);

        $this->viewBuilder()->setOption('serialize', ['status', 'message']);
    }
	
    public function delete()
    {
        $header = $this->request->getHeaders();
        if(!$this->verifyToken($header)){
		$this->set([
		    'status' => false,
		    'message' => 'Invalid token',
		]);
		$this->viewBuilder()->setOption('serialize', ['status', 'message']);
		return;
        }
        
        $this->request->allowMethod(['delete']);
        
        $user_id = $this->request->getParam('id');

        $user = $this->Articles->get($user_id);

        if (!empty($user)) {
            // user found
            if ($this->Users->delete($user)) {
                // user deleted
                $status = true;
                $message = 'User has been deleted';
            } else {
                // failed to delete
                $status = false;
                $message = 'Failed to delete user';
            }
        } else {
            // not found
            $status = false;
            $message = 'User does not exists';
        }

        $this->set([
            'status' => $status,
            'message' => $message
        ]);

        $this->viewBuilder()->setOption('serialize', ['status', 'message']);
    }
    public function generate_token(){
	$access_token = md5(uniqid().rand(1000000, 9999999));
        return $access_token;
    }

	
}
