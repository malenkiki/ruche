<?php
/*
 * Copyright (c) 2014 Michel Petit <petit.michel@gmail.com>
 * 
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 * 
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */


namespace Malenki\Ruche\Controller;


/**
 * Base controller used to create all other controllers of ruche API.
 * 
 * @property-read $app The Slim application
 * @property-read $res The Response object
 * @property-read $req The Request object
 * @author Michel Petit <petit.michel@gmail.com> 
 * @license MIT
 */
class Controller
{
    /**
     * Contains the Slim application object.
     * 
     * @var \Slim\Slim
     * @access protected
     */
    protected $app;

    /**
     * Contains the Slim HTTP response object. 
     * 
     * @var Slim\Http\Response
     * @access protected
     */
    protected $res;

    /**
     * Contains the Slim HTTP request object.
     * 
     * @var Slim\Http\Request
     * @access protected
     */
    protected $req;



    /**
     * Defines magic getters Slim main app, response and request. 
     * 
     * @param string $name 
     * @access public
     * @return object
     */
    public function __get($name)
    {
        if(in_array($name, array('app', 'res', 'req')))
        {
            return $this->$name;
        }
    }



    /**
     * Constructs object by setting response, request and main Slim app. 
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->app = \Slim\Slim::getInstance();
        $this->res = $this->app->response();
        $this->req = $this->app->request();
    }



    public function init(){
    }

    
    
    /**
     * Run action for given controller with optionnal args.
     * 
     * @param string $controller 
     * @param string $action 
     * @param array $args 
     * @static
     * @access public
     * @return mixed
     */
    public static function action($controller, $action, $args = array())
    {
        $class_name = sprintf('\\'.__NAMESPACE__. '\%sController', $controller);
        $action_name = sprintf('%sAction', $action);


        // SQLITE3 is mandatory!!!
        if(!extension_loaded('sqlite3'))
        {
            $app = \Slim\Slim::getInstance();
            $app->response()->status(500);
            echo json_encode('PHP extension "sqlite3" is not available. Ruche cannot run without it!');
            exit();
        }

        $obj = new $class_name();
        call_user_func(array($obj, 'init'));
        return call_user_func_array(array($obj, $action_name), $args);
    }
}
