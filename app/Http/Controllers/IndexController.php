<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Page;
use App\Service;
use App\Portfolio;
use App\People;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class IndexController extends Controller
{
    public function execute(Request $request){

       //какой тип запроса использ. пользователь
       if($request->isMethod('post')){

          //формирование ошибки
          $messages = [
             'required' => "Поле :attribute обязательно к заполнению",
             'email' => "Поле :attribute должно соответствовать E-mail адресу"
          ];

          //Обработка входящих данных из формы валидатором
          $this->validate($request, [
             'name'=>'required|max:50',
             'email'=>'required|email',
             'text'=>'required'
          ], $messages);

          //получим данные объекта, которые хранятся в форме и присвоим к переменной data
          $data = $request->all();

          //получили набор данных, и отправим их на почту
          $result = Mail::send('site.email', ['data'=>$data], function($message) use($data){

             $mail_admin = env('MAIL_ADMIN');
             $message->from($data['email'], $data['name']);
             $message->to($mail_admin)->subject('Question');
          });

          if($result){
             return redirect()->route('home')->with('status', 'Email is send');
          }

       }

       //выбираем все записи из таблиц
       $pages = Page::all();
       $portfolios = Portfolio::all();
       $services = Service::all();
       $peoples =People::all();

       //получим доп инф. о фильтрах табл portfolios
       $tags = DB::table('portfolios')->distinct()->pluck('filter');



       //будет содержать список меню
       $menu = array();
       //циклом выводим меню
       foreach($pages as $page){
          //отдельный пункт меню
         $item = array('title'=>$page->name, 'alias'=>$page->alias);
          //добавим отдельный пункт меню в массив $menu
          array_push($menu, $item);
       }

       $item = array('title'=>'Services', 'alias'=>'service');
       array_push($menu, $item);

       $item = array('title'=>'Portfolio', 'alias'=>'Portfolio');
       array_push($menu, $item);

       $item = array('title'=>'Team', 'alias'=>'team');
       array_push($menu, $item);

       $item = array('title'=>'Contact', 'alias'=>'contact');
       array_push($menu, $item);

       return view('site.index', array(
                               //ключи имена переменных
                               //эти переменные будут доступны в шаблоне
                               'menu'=>$menu,
                               'pages'=>$pages,
                               'services'=>$services,
                               'portfolios'=>$portfolios,
                               'peoples'=>$peoples,
                               'tags'=>$tags,
                            ));

    }
}
