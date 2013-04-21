<?php
require '../vendor/autoload.php';

Slim\Slim::registerAutoloader();

use RedBean_Facade as R;
use Malenki\Ruche\Controller\Controller as Controller;
use Malenki\Ruche\Util\RichText as RichText;
use Malenki\Ruche\Util\Curl as Curl;

/* Disable until this issue is solved : https://github.com/codeguy/Slim-Extras/pull/58
Slim\Extras\Views\Twig::$twigDirectory = dirname(__FILE__) . '/vendor/twig/twig';
Slim\Extras\Views\Twig::$twigExtensions = array(
        'Twig_Extensions_Slim',
        'Twig_Extensions_Extension_I18n' // Added i18n //
);
 */

$app = new Slim\Slim(array(
    //'view' => new Slim\Extras\Views\Twig(),
    'locales.path' => '../i18n/',
    'templates.path' => '../templates'
));

Slim\Route::setDefaultConditions(array(
    'pid' => '\d+',
    'mid' => '\d+',
    'uid' => '\d+'
));

R::setup('sqlite:../db/ruche.db');
R::freeze(true);

/*
    // Put following line into right way
    // Set language to English
    putenv('LC_ALL=en_GB');
    setlocale(LC_ALL, 'en_GB');

    // Specify the location of the translation tables
    bindtextdomain('myAppPhp', ROOT.'/i18n');
    bind_textdomain_codeset('ruche', 'UTF-8');

    // Choose domain
    textdomain('ruche');
 */


/**
 * WEB SITE PART
 */

// GET route
$app->get('/', function () {
    echo "TODO :)";
});


// List all projects. Some of them could be hidden…
$app->get('/projects(/)', function(){
    $app = \Slim\Slim::getInstance();
    $c = new Curl('http://ruche.local/api/projects/');
    $c->returnTransfer = true;
    $c->connectTimeOut = 4;

    $data = $c->execute();
    
    $app->render('WebLayout.php', array('tpl' => 'WebProjects', 'is500' => $c->is500(), 'prj' => $data));
});

$app->get('/project/create(/)', function(){
    $app = \Slim\Slim::getInstance();
    $app->render('WebLayout.php', array('tpl' => 'WebProjectsCreate'));
});

$app->post('/project/create(/)', function(){

});


// Show informations about one project
$app->get('/project/:prj(/)', function($prj){
    $app = \Slim\Slim::getInstance();
    $c = new Curl(sprintf('http://ruche.local/api/project-by-slug/%s/', $prj));
    $c->returnTransfer = true;
    $c->connectTimeOut = 4;

    $prj = $c->execute();


    // TODO : limiter aux 3 dernières milestones
    $c = new Curl(sprintf('http://ruche.local/api/projects/%d/milestones/', $prj->id));
    $c->returnTransfer = true;
    $c->connectTimeOut = 4;

    $mls = $c->execute();

    // TODO: Activité

    $app->render('WebLayout.php', array('tpl' => 'WebProjectsShow', 'prj' => $prj, 'mls' => $mls));
});

// Edit form for the project given by its slug
$app->get('/project/:prj/edit(/)', function($prj){
});

// Update data about project prj
$app->put('/project/:prj/edit(/)', function($prj){
});

// List all milestones about prj project
$app->get('/project/:prj/roadmap(/)', function($prj){
    $app = \Slim\Slim::getInstance();
    $c = new Curl(sprintf('http://ruche.local/api/project-by-slug/%s/', $prj));
    $c->returnTransfer = true;
    $c->connectTimeOut = 4;

    $prj = $c->execute();


    $c = new Curl(sprintf('http://ruche.local/api/projects/%d/milestones/', $prj->id));
    $c->returnTransfer = true;
    $c->connectTimeOut = 4;

    $mls = $c->execute();

    $app->render('WebLayout.php', array('tpl' => 'WebMilestonesShow', 'prj' => $prj, 'mls' => $mls));
});

// List all tickets about prj project
$app->get('/project/:prj/report(/)', function($prj){
});

// Create new ticket for project $prj
$app->get('/project/:prj/ticket/create(/)', function($prj){
});

$app->post('/project/:prj/ticket/create(/)', function($prj){
});




// Get ticket #tck
$app->get('/ticket/:tck(/)', function($tck){
});




// Hum… Clear, no?
$app->get('/login(/)', function(){});









/**
 * API PART
 */

// API’s root. Display some help about this API.
$app->get('/api(/(:lang))', function ($lang = 'fr') {
    Controller::action('Api', 'root', array($lang));
})->conditions(array('lang' => '(en|fr)'));




/**
 *  Projets’ routes
 */

// This is route to create new project
$app->post('/api/projects(/)', function () {
    Controller::action('ApiProject', 'post');
});


// This is route to get project $pid 
$app->get('/api/projects/:pid(/)', function($pid){
    Controller::action('ApiProject', 'get', array($pid));
});

// This is route to get project by its slug $slug 
$app->get('/api/project-by-slug/:slug(/)', function($slug){
    Controller::action('ApiProject', 'getBySlug', array($slug));
});



// This route gets list of all projects
$app->get('/api/projects(/)', function () {
    Controller::action('ApiProject', 'get');
});



// This route creates new milestone for project $pid
$app->post('/api/projects/:pid/milestones(/)', function ($pid) {
    printf('This route creates new milestone for project %d', $pid);
});



// This route lists milestones available into project $pid 
$app->get('/api/projects/:pid/milestones(/)', function ($pid) {
    Controller::action('ApiMilestone', 'getList', array($pid));
});



// This route gets informations about milestone $mid 
$app->get('/api/milestones/:mid(/)', function ($mid) {
    Controller::action('ApiMilestone', 'get', array($mid));
});



// This route updates milestone $mid
$app->put('/api/milestones/:mid(/)', function ($mid) {
    printf('This route updates milestone %d', $mid);
});



// This route gets list of tickets for milestone $mid
$app->get('/api/milestones/:mid/tickets(/)', function ($mid) {
    printf('This route gets informations about milestone %d', $mid);
});



// This route adds new user into project $pid 
$app->post('/api/projects/:pid/users(/)', function ($pid) {
    printf('This route adds new user into project %d', $pid);
});



// This route adds new user into project $pid
$app->get('/api/projects/:pid/users/:uid(/)', function ($pid, $uid) {
    printf('This route adds new user into project %d', $pid);
});




$app->run();
