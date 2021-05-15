<?php

use App\Http\Controllers\ClientsSettingsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['auth', 'checksinglesession'], 'prefix' => 'html5_player_api'], function () {

    Route::get('/', function () {
        echo 'Welcome html5 player api :-)';
    });

    /**
     * Adding i18n route
     */

    // GET Pictos list
    Route::get('/i18n/{languageId}', function ($languageId) {
        require_once('public/html5_player/app/i18n/get_i18n_strings.php');
    });
    // GET Tutorial Translations
    Route::get('/tutorial/{language}/{appType}', function ($language, $appType) {
        require_once('public/html5_player/app/i18n/get_tutorial_strings.php');
    });

    /**
     * Adding routes for Template Editor
     */

    // GET saved template datas
    Route::get('/template_editor/template/{templateId}', function ($templateId) {
        require_once('public/html5_player/app/template_editor/get_template.php');
    });

    // GET Pictos list
    Route::get('/template_editor/pictos', function () {
        require_once('public/html5_player/app/template_editor/get_pictos.php');
    });

    // POST template datas to save
    Route::post('/template_editor/template/{templateId}', function ($templateId) {
        require_once('public/html5_player/app/template_editor/post_template.php');
    });

    /**
     * End Of Template Editor routes
     * */

    // Route pour afficher ou créer le json.
    Route::post('/courses/{productId}/{courseId}/json', function ($productId, $courseId) {
        require_once('public/html5_player/app/course/courseInJson.php');
    });

    // Route pour connaitre la configuration du player par rapport à un cours
    Route::post('/courses/{productId}/{courseId}/player/config', function ($productId, $courseId) {
        require_once('public/html5_player/app/playerConfig/playerConfig.php');
    });

    // Route pour connaitre la configuration du player pour un utilisateur
    Route::post('/courses/{formationId}/{productId}/{courseId}/user/{userId}/config', function ($formationId, $productId, $courseId, $userId) {
        require_once('public/html5_player/app/userCourse/userCourseConfig.php');
    });

    // Route pour enregistrer l'évaluation de l'utilisateur
    Route::post('/courses/{productId}/{courseId}/user/{userId}/screen/{screenId}/{state}/evaluation', function ($productId, $courseId, $userId, $screenId, $state) {
        require_once('public/html5_player/app/userCourse/userCourseEvaluation.php');
    });

    // Route pour enregistrer la progression de l'utilisateur
    Route::post('/courses/{productId}/{courseId}/user/{userId}/screen/{screenId}/{state}', function ($productId, $courseId, $userId, $screenId, $state) {
        require_once('public/html5_player/app/userCourse/userCourseProgression.php');
    });

    // Route pour connaitre l'avancé de l'utilisateur.
    Route::get('/courses/{productId}/{courseId}/user/{userId}', function ($productId, $courseId, $userId) {
        require_once('public/html5_player/app/userCourse/userCourseHistoric.php');
    });

    Route::get('/progression/(.*)/user/{userId}', function ($productId, $userId) {
        require_once('public/html5_player/app/userCourse/userProgression.php');
    });

    // Route pour créer une session à un utilisateur
    Route::get('/user/{userId}/session/courses/{productId}', function ($userId, $productId) {
        require_once('public/html5_player/app/user/userSession.php');
    });

    // Route pour savoir si un utilisateur est connecté
    Route::get('/user/isConnect', function () {
        require_once('public/html5_player/app/user/userIsConnect.php');
    });

    // Route pour récupérer les informations d'un utilisateur
    Route::get('/user/{userId}', function ($userId) {
        require_once('public/html5_player/app/user/userInfos.php');
    });

    // Route for report bug
    Route::post('/report/{userId}', function ($userId) {
        require_once('public/html5_player/app/user/userReport.php');
    });
});


Route::get('', '\App\Http\Controllers\HomeController@index');

Auth::routes();

Route::group(['middleware' => ['auth', 'checksinglesession'], 'prefix' => ''], function () {
    Route::get('/', '\App\Http\Controllers\admin\DashController@index');
    Route::get('home', '\App\Http\Controllers\HomeController@index')->name('home');
    Route::get('session', '\App\Http\Controllers\SessionController@index')->name('session');
    Route::get('lesson', '\App\Http\Controllers\LessonController@index')->name('lesson');
    Route::get('admindash', '\App\Http\Controllers\admin\DashController@index')->name('admin.dash');
    Route::get('dash', '\App\Http\Controllers\common\DashController@index')->name('dash');
    Route::get('student', '\App\Http\Controllers\StudentController@index')->name('student');
    Route::get('template', '\App\Http\Controllers\TemplateController@index')->name('template');
    Route::get('template_editor', '\App\Http\Controllers\TemplateEditorController@index')->name('template_editor');
    Route::get('changeLanuguage', function (Request $request) {
        session(['language' => $request->language]);
    })->name('changeLanguage');
    Route::post('searchfromdictionary', function (Request $request) {
        $request->keyword;
        // $users = DB::table('users')
        //     ->leftJoin('posts', 'users.id', '=', 'posts.user_id')
        //     ->get();
    })->name('searchfromdictionary');
    Route::post('template/update', '\App\Http\Controllers\TemplateController@update')->name('template.update');
    Route::post('template/add', '\App\Http\Controllers\TemplateController@add')->name('template.add');
    Route::post('template/delete', '\App\Http\Controllers\TemplateController@delete')->name('template.delete');
    Route::get('superadminsettings', '\App\Http\Controllers\ClientController@index')->name('superadminsettings');
    Route::resource('languageadmin', \App\Http\Controllers\LanguageManageController::class);
    Route::resource('clients', \App\Http\Controllers\ClientController::class);
    Route::resource('user', \App\Http\Controllers\StudentController::class);

    Route::post('user/findgroup', '\App\Http\Controllers\useradmin\GroupController@findGroup')->name('findgroup');
    Route::post('user/getuserfromgroup', '\App\Http\Controllers\useradmin\GroupController@getUserFromGroup')->name('getuserfromgroup');
    Route::post('user/getgroupfromuser', '\App\Http\Controllers\useradmin\GroupController@getGroupFromUser')->name('getgroupfromuser');
    Route::resource('group', \App\Http\Controllers\useradmin\GroupController::class);

    Route::post('user/findsession', '\App\Http\Controllers\SessionController@findSession')->name('findsession');

    Route::post('user/findcompany', '\App\Http\Controllers\useradmin\CompanyController@findCompany')->name('findcompany');
    Route::post('user/getuserfromcompany', '\App\Http\Controllers\useradmin\CompanyController@getUserFromCompany')->name('getuserfromcompany');
    Route::resource('company', \App\Http\Controllers\useradmin\CompanyController::class);

    Route::post('user/finduser', '\App\Http\Controllers\StudentController@findUser')->name('finduser');
    Route::post('user/getuserfromfunction', '\App\Http\Controllers\StudentController@getUserFromFunction')->name('getuserfromfunction');
    Route::post('user/edituser', '\App\Http\Controllers\StudentController@editUser')->name('edituser');
    Route::post('user/adduser', '\App\Http\Controllers\StudentController@addUser')->name('adduser');
    Route::post('user/deleteuser', '\App\Http\Controllers\StudentController@deleteUser')->name('deleteuser');

    Route::post('user/findfunction', '\App\Http\Controllers\useradmin\PositionController@findPosition')->name('findfunction');
    Route::resource('function', \App\Http\Controllers\useradmin\PositionController::class);

    Route::post('user/userjointogroup', '\App\Http\Controllers\StudentController@userJoinToGroup')->name('userjointogroup');
    Route::post('user/userjointocompany', '\App\Http\Controllers\StudentController@userJoinToCompany')->name('userjointocompany');
    Route::post('user/userjointofunction', '\App\Http\Controllers\StudentController@userJoinToPosition')->name('userjointofunction');
});



Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
