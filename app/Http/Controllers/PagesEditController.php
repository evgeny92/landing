<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;

class PagesEditController extends Controller
{
    public function execute(Page $page, Request $request){

       //приводим к массиву
       $old = $page->toArray();

       if(view()->exists('admin.pages_edit')){

          $data = [
             'title'=>'Редактирование страницы - '.$old['name'],
             'data'=>$old
          ];

          return view('admin.pages_edit', $data);
       }


    }
}
