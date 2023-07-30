<?php

namespace app\Controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\core\Session;
use app\Models\Login;
use app\Models\User;

class AuthController extends Controller
{
    public function Login(Request $request, Response $response, Session $session)
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
}