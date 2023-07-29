<?php 

namespace app\Controllers;

use app\core\Controller;

/*
*@package app\Controllers
*/
class siteController extends Controller
{
    public function Home(){
        $params = [
            "Title" => "Mvc",
        ];
        
        return $this->render("Home",$params);

    }
    public function contact(){
        echo $this->getLayout();
        return $this->render("contact");
    }
    public function handleContact(){
        var_dump($this->getBody());
    }
}

?>