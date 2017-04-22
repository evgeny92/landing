<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Page;
use App\Service;
use App\Portfolio;
use App\People;

class IndexController extends Controller
{
    public function execute(Request $request){

       //выбираем все записи из таблиц
       $pages = Page::all();
       $portfolios = Portfolio::all();
       $services = Service::all();
       $peoples =People::all();


       //будет сожержать список меню
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
                            ));

    }
}
