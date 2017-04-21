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


       return view('site.index');

    }
}
