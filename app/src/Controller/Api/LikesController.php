<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\AppController;

class LikesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('Likes');
        $this->loadModel('Articles');
    }
	
    public function add()
    {
        $this->request->allowMethod(['post']);
    	$header = $this->request->getHeaders();
    	$auth = $this->verifyToken($header);
        if(!$auth){
		$this->set([
		    'status' => false,
		    'message' => 'Invalid token',
		]);
		$this->viewBuilder()->setOption('serialize', ['status', 'message']);
		return;
        }
        

        // form data
        $formData = $this->request->getData();

        // user_id check rules
        $likeData = $this->Likes->find()->where([
            'user_id' => $auth['id'],
            'article_id' => $formData['article_id'],
        ])->first();

        if (!empty($likeData)) {
            // already exists
            $status = false;
            $message = 'like already exists';
        } else {
            // insert new article
            $likeObject = $this->Likes->newEmptyEntity();
            $likeObject->user_id = $auth['id'];
            $articleObject = $this->Likes->patchEntity($likeObject, $formData);

            if ($this->Likes->save($articleObject)) {
                // success response
                $articleData = $this->Articles->find()->where([
		    'id' => $formData['article_id']
		])->first();
		
		$articleData->count = $articleData->count+1;
		$this->Articles->save($articleData);

                $status = true;
                $message = 'Like has been created';
            } else {
                // error response
                $status = false;
                $message = 'Failed to create like';
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
    	 $auth = $this->verifyToken($header);
        if(!$auth){
		$this->set([
		    'status' => false,
		    'message' => 'Invalid token',
		]);
		$this->viewBuilder()->setOption('serialize', ['status', 'message']);
		return;
        }
        
        $this->request->allowMethod(['get']);

        $likes = $this->Likes->find()->where([
		    'user_id' => $auth["id"]
		])->toList();

        $this->set([
            'status' => true,
            'message' => 'likeslist',
            'data' => $likes
        ]);

        $this->viewBuilder()->setOption('serialize', ['status', 'message', 'data']);
    }	
	
}
