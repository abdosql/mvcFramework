<?php

namespace app\Controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Middlewares\AuthMiddleware;
use app\core\Request;
use app\core\Response;
use app\core\Session;
use app\Models\Login;
use app\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->NewMiddleware(new AuthMiddleware(["Profile"]));
    }

    public function Login(Request $request, Response $response)
    {
        $loginForm = new Login();
        if ($request->isPost()){
            $loginForm->loadData($request->getBody());
            if ($loginForm->Validate() && $loginForm->login()){
                $response->redirect("/");
            }else{
                echo "error";
            }
        }
        $this->setLayout("main");
        return $this->render("Login",[
            'model' => $loginForm
        ]);
    }
    public function Register(Request $request, Response $response, Session $session)
    {
        //creating instance of the model
        $User = new User();
        //checking if the request is post
        if ($request->isPost()) {
            $User->loadData($this->getBody());
            if ($User->Validate() && $User->save()){
                $session->setFlash("success","Register successfully.");
                $response->redirect("/");
                return "Success";
            } else {
                return $this->render("Register", [
                    'model' => $User,
                ]);
            }
        } else {
            $this->setLayout("main");
            return $this->render("Register", [
                'model' => $User,
            ]);
        }
    }
    public function _logout(Request $request, Response $response, Session $session)
    {
        $this->setLayout("main");
        if ($request->isGet()){

            Application::$app->_logout();
            $response->redirect("/");
            $session->setFlash("success", "Now You Are Loged Out.");
        }
    }
    public function Profile(Request $request, Response $response, Session $session){
        Application::$app->view->setTitle("Profile");
        return $this->render("Profile");
    }
}