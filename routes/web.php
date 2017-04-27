<?php

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


/*
 * Формирование маршрута главн. стр.
 * используя методы гет и пост
 * ячейка uses хранит инф. о том какой контроллер,
 * обработает запрос
 */
Route::group([],function() {

   Route::match(['get','post'],'/',['uses'=>'IndexController@execute','as'=>'home']);
   Route::get('/page/{alias}',['uses'=>'PageController@execute','as'=>'page']);

   Route::auth();

});

Route::match(['get', 'post'], '/', ['uses'=>'IndexController@execute', 'as'=>'home']);

/*
 * Маршрут на ссылку read more
 */
Route::get('/page/{alias}', ['uses'=>'PageController@execute', 'as'=>'page'] );

/*
 * Формирование маршрута для аутентификации
 */
Route::auth();

/*
 * Группа маршрутов для закрытого раздела
 * данного проекта
 * например admin/page, admin/portfolio и тд
 */
Route::group(['group'=>'admin', 'middleware'=>'auth'], function(){

   /*
    * Маршрут главн. стр. панели администрации
    * /admin
    */
   Route::get('/admin', function(){

      //проверка на сущ шаблона
      if(view()->exists('admin.index')){
         $data = ['title'=>'Панель администратора'];
         return view('admin.index', $data);
      }

  });

   /*
    * Группа маршрутов для работы с страницами, т.е. с инф.
    * которая хранится в табл. pages
    * /admin/pages
    *
    */
    Route::group(['prefix'=>'pages'], function(){
      /*
       * Главн. стр раздела по управлению стр.
       */
      Route::get('/', ['uses'=>'PagesController@execute', 'as'=>'pages']);

      //admin/pages/add
      Route::match(['get', 'post'], '/add', ['uses'=>'PagesAddController@execute', 'as'=>'pagesAdd']);
      //admin/edit/2
      Route::match(['get', 'post', 'delete'], '/edit/{page}', ['uses'=>'PagesEditController@execute', 'as'=>'pagesEdit']);
   });

   /*
    * Маршруты для работы с инф. которая хранится в
    * табл. portfolios, т.е. для редактирования, дбавления, удаленя
    * портфолио
    */
   Route::group(['prefix'=>'portfolios'], function(){

      /*
       * Главн. стр раздела портфолио
       */
      Route::get('/', ['uses'=>'PortfolioController@execute', 'as'=>'portfolio']);

      /*
       * маршруты для реализации какого либо действия
       */
      Route::match(['get', 'post'], '/add', ['uses'=>'PortfolioAddController@execute', 'as'=>'portfolioAdd']);

      Route::match(['get', 'post', 'delete'], '/edit/{portfolio}', ['uses'=>'PortfolioEditController@execute', 'as'=>'portfolioEdit']);
   });

   /*
    * Маршруты для работы с инф. которая хранится в
    * табл. services, т.е. для редактирования, дбавления, удаленя
    * сервиса
    */
   Route::group(['prefix'=>'services'], function(){

      /*
       * Главн. стр раздела сервиса
       */
      Route::get('/', ['uses'=>'ServiceController@execute', 'as'=>'services']);

      /*
       * маршруты для реализации какого либо действия
       */
      Route::match(['get', 'post'], '/add', ['uses'=>'ServiceAddController@execute', 'as'=>'serviceAdd']);

      Route::match(['get', 'post', 'delete'], '/edit/{service}', ['uses'=>'ServiceEditController@execute', 'as'=>'serviceEdit']);
   });
});


//Route::get('/home', 'HomeController@index');
