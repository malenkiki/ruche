<?php
require '../vendor/autoload.php';

Slim\Slim::registerAutoloader();

use RedBean_Facade as R;
use Malenki\Ruche\Controller\Controller as Controller;
use Malenki\Ruche\Util\RichText as RichText;

$app = new Slim\Slim(array(
    'locales.path' => '../i18n/'
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
