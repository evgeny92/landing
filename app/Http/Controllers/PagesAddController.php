<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PagesAddController extends Controller
{


    public function execute(Request $request){

       if($request->isMethod('post')){
          //$input хранит в себе всю инф. в полях
          //исключение поля(_token)
          $input = $request->except('_token');

          $messages = [
             'required'=>'Поле :attribute, обязательно к заполнению',
             'unique'=>'Поле :attribute, уже существует'
          ];

          //валидация данных
          $validator = Validator::make($input, [
             'name'=>'required|max:255',
             'alias'=>'required|unique:pages|max:255',
             'text'=>'required'
          ], $messages);

          //вернёт true если будет ошибка
          if($validator->fails()){
             return redirect()->route('pagesAdd')->withErrors($validator)->withInput();
          }

          //возвращает true если файл содержится в объекте request
          if($request->hasFile('images')){
             //возвращает экзеипляр объекта UploadedFile, для работы с файлами
             $file = $request->file('images');
             //возвращает оригинальное имя файла
             $input['images'] = $file->getClientOriginalName();
             //перенос файла в другую директорию
             $file->move(public_path().'/assets/img', $input['images']);
          }

          //добавление в инф в бд
          $page = new Page();
          //метод заполняет поля модели данными, которые хранятся в массиве и передаются
          //в качестве первого аргумента
          $page->fill($input);

          //сохранение, если true то редирект
          if($page->save()){
             return redirect('admin')->with('status', 'Страница добавлена');
          }
       }

       if(view()->exists('admin.pages_add')){
          $data = [
            'title'=>'Новая страница'
          ];
          return view('admin.pages_add', $data);
       }
       abort(404);
    }
}
