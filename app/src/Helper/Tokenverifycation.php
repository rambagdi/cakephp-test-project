<?php
namespace App\Helper;
use Cake\View\Helper;

class Tokenverifycation extends Helper
{
    public function verifyToken($token)
    {
        $this->loadModel('Users');
        $verify = $this->Users->find()->where([
            'token' => $token
        ])->first();
        if (!empty($verify)) {
            return true;
        } else {
        	return false;
        }
        
    }

}
