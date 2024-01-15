<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\LoginForm;
use app\models\User;

class AuthController extends Controller
{
    public function login(Request $request,Response $response): string
    {
        $loginForm = new LoginForm();
        $this->setLayout('auth');
        if ($request->isPost()){
            $loginForm->loadData($request->getBody());
            if ($loginForm->validate() && $loginForm->login()){
                Application::$app->session->setFlash('Welcome!','Welcome ^_^');
                $response->redirect('/');
            }
            return $this->render('login',[
                'model' => $loginForm
            ]);
        }

        return $this->render('login',[
            'model' => $loginForm
        ]);
    }
    public function register(Request $request): string
    {
        $this->setLayout('auth');
        $user = new User();
        if ($request->isPost()){
            $user->loadData($request->getBody());
            if($user->validate() && $user->save()){
                Application::$app->session->setFlash('registration','Thanks for registration!');
                Application::$app->response->redirect('/');
            }
            return $this->render('register',[
                'model' => $user
            ]);

        }

        return $this->render('register',[
            'model' => $user
        ]);
    }
    public function logout(Request $request,Response $response){
        Application::$app->logout();
        $response->redirect('/');
    }
}