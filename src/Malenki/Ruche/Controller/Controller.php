<?php

namespace Malenki\Ruche\Controller;


class Controller
{
    protected $app;
    protected $res;
    protected $req;


    public function __construct()
    {
        $this->app = \Slim\Slim::getInstance();
        $this->res = $this->app->response();
        $this->req = $this->app->request();
    }


    public function init(){
    }

    
    
    public static function action($controller, $action, $args = array())
    {
        $class_name = sprintf('\\'.__NAMESPACE__. '\%sController', $controller);
        $action_name = sprintf('%sAction', $action);

        $obj = new $class_name();
        call_user_func(array($obj, 'init'));
        return call_user_func_array(array($obj, $action_name), $args);
    }
}
