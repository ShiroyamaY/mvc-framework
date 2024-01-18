<?php

namespace app\controllers;
use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\ContactForm;

class SiteController extends Controller{
    public function home(){
        $params = [
          'name' => 'ShiroyamaY'
        ];
        return $this->render('home',$params);
    }
    public function contact(Request $request,Response $response){
        $contactForm  = new ContactForm();
        if ($request->isPost()){
            $contactForm->loadData($request->getBody());
            if ($contactForm->validate() && $contactForm->save()){
                Application::$app->session->setFlash('contact','Thank you for uploading form');
                $response->redirect('/');
            }
        }
        return $this->render('contact',
            [ 'model' => $contactForm ]);
    }
}