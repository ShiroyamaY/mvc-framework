<?php

namespace app\core;

use app\core\db\Database;
use app\core\db\DbModel;
use app\models\User;


class Application
{
    public static string $ROOT_DIR;
    public string $userClass;
    public Router $router;
    public Request $request;
    public Response $response;
    public ?Controller $controller = null;
    public View $view;
    public Database $db;

    public static Application $app;
    public Session $session;
    public ?User $user = null;
    public string $layout = 'main';

    public function getController(): Controller
    {
        return $this->controller;
    }

    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }

    public function __construct(string $ROOT_DIR,array $config)
    {
        $this->userClass = $config['userClass'];
        self::$ROOT_DIR = $ROOT_DIR;
        self::$app = $this;
        $this->request = Request::getInstance();
        $this->response = new Response();
        $this->router = Router::getInstance($this->request,$this->response);
        $this->db = Database::getInstance($config['db']);
        $this->session = new Session();
        $primaryValue = $this->session->get('user');
        if ($primaryValue){
            $primaryKey = call_user_func([$this->userClass,'primaryKey']);
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        }
        $this->view = new View();
    }
    public function run(): void
    {
        try{
            echo $this->router->resolve();
        }catch (\Exception $e){
            echo $this->view->renderView('_error',['exception' => $e]);
        }
    }
    public function login(DbModel $user): bool
    {
        $this->user = $user;
        $primaryKey = $user::primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user',$primaryValue);
        return true;
    }
    public function logout(): void
    {
        $this->user = null;
        $this->session->remove('user');
    }
    public static function isGuest(): bool
    {
        return !self::$app->user;
    }
}