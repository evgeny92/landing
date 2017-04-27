<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PagesEditController extends Controller
{
    public function execute(Page $page, Request $request){

       //удаление страницы
       if($request->isMethod('delete')){
          $page->delete();
          return redirect('admin')->with('status', 'Старинаца удалена');
       }

       //если метод пост
       if($request->isMethod('post')){

          $input = $request->except('_token');

          $validator = Validator::make($input, [
             'name'=>'required|max:255',
             'alias'=>'required|max:255|unique:pages,alias,'.$input['id'],
             'text'=>'required',
          ]);

          if($validator->fails()){
             //route('pagesEdit', ['page'])->идентификатор pages/edit/1
             return redirect()
                ->route('pagesEdit', ['page'=>$input['id']])
                ->withErrors($validator);
          }

          //загружается ли файл на сервер, images(имя поля)
          if($request->hasFile('images')){

             //сохраним в переменню объект класса uploadedFile
             $file = $request->file('images');
             //переносим в другую директорию
             $file->move(public_path().'/assets/img', $file->getClientOriginalName());
             $input['images'] = $file->getClientOriginalName();
          }else{
             //изображение которое было загруженно ранее
             $input['images'] = $input['old_images'];
          }
          //удалить лишнее из массива input
          unset($input['old_images']);
          //заполняем модель новыми значениями
          $page->fill($input);
          //пересохраняем
          if($page->update()){
             return redirect('admin')->with('status', 'Страница обновлена');
          }
       }

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
