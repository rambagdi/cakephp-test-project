<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\AppController;

class ArticlesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('Articles');
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

        // title check rules
        $articleData = $this->Articles->find()->where([
            'title' => $formData['title']
        ])->first();

        if (!empty($articleData)) {
            // already exists
            $status = false;
            $message = 'Title already exists';
        } else {
            // insert new article
            $articleObject = $this->Articles->newEmptyEntity();

            $articleObject = $this->Articles->patchEntity($articleObject, $formData);

            if ($this->Articles->save($articleObject)) {
                // success response
                $status = true;
                $message = 'Article has been created';
            } else {
                // error response
                $status = false;
                $message = 'Failed to create article';
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

        $articles = $this->Articles->find()->toList();

        $this->set([
            'status' => true,
            'message' => 'Article list',
            'data' => $articles
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

        $article_id = $this->request->getParam('id');

        $articleInfo = $this->request->getData();

        // article check
        $article = $this->Articles->get($article_id);

        if (!empty($article)) {
            // article exists
            $article = $this->Articles->patchEntity($article, $articleInfo);

            if ($this->Articles->save($article)) {
                // success response
                $status = true;
                $message = 'Article has been updated';
            } else {
                // error response
                $status = false;
                $message = 'Failed to update article';
            }
        } else {
            // article not found
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
        
        $article_id = $this->request->getParam('id');

        $article = $this->Articles->get($article_id);

        if (!empty($article)) {
            // article found
            if ($this->Articles->delete($article)) {
                // article deleted
                $status = true;
                $message = 'Article has been deleted';
            } else {
                // failed to delete
                $status = false;
                $message = 'Failed to delete article';
            }
        } else {
            // not found
            $status = false;
            $message = 'Article does not exists';
        }

        $this->set([
            'status' => $status,
            'message' => $message
        ]);

        $this->viewBuilder()->setOption('serialize', ['status', 'message']);
    }
	
}
