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
    }
	
    public function add()
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
        $this->request->allowMethod(['post']);

        // form data
        $formData = $this->request->getData();

        // user_id check rules
        $likeData = $this->Likes->find()->where([
            'user_id' => $formData['user_id'],
            'article_id' => $formData['article_id'],
        ])->first();

        if (!empty($likeData)) {
            // already exists
            $status = false;
            $message = 'like already exists';
        } else {
            // insert new article
            $likeObject = $this->Likes->newEmptyEntity();

            $articleObject = $this->Likes->patchEntity($likeObject, $formData);

            if ($this->Likes->save($articleObject)) {
                // success response
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
        if(!$this->verifyToken($header)){
		$this->set([
		    'status' => false,
		    'message' => 'Invalid token',
		]);
		$this->viewBuilder()->setOption('serialize', ['status', 'message']);
		return;
        }
        
        $this->request->allowMethod(['get']);

        $likes = $this->Likes->find()->toList();

        $this->set([
            'status' => true,
            'message' => 'likeslist',
            'data' => $likes
        ]);

        $this->viewBuilder()->setOption('serialize', ['status', 'message', 'data']);
    }	
	
}
