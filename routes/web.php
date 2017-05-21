<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('swagger.json',"SwaggerController@json");

$app->get('/deploy/run',"DeployController@run");
$app->post('/deploy/run',"DeployController@run");

$app->get('/', function () use ($app) {
    return $app->version();
});


//$app->group();

//$app->get('/api/tests', ['uses'=>"TestController@index"]);
$app->get('/api/tests', ['middleware' => ['fields', 'form:TestFormRequest'],'uses'=>"TestController@index"]);
//$app->get('/api/butlers', ['middleware' => ['auth'],'uses'=>"ButlerController@index"]);


//工单日志
$app->get('/joblogs/{id}', ['uses'=>"JobLogController@listByJobId"]);


//工单
$app->get('/jobs/listByPhone', ['middleware' => ['fields', 'form:JobsFormRequest'],'uses'=>"JobsController@getJobsByShUserId"]);
