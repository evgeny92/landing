<?php

namespace App\Http\Controllers;

use App\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PortfolioAddController extends Controller
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
             'filter'=>'required|unique:portfolios|max:255'
          ], $messages);

          //вернёт true если будет ошибка
          if($validator->fails()){
             return redirect()->route('portfolioAdd')->withErrors($validator)->withInput();
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
          $portfolio = new Portfolio();
          //метод заполняет поля модели данными, которые хранятся в массиве и передаются
          //в качестве первого аргумента
          $portfolio->fill($input);
          //сохранение, если true то редирект
          if($portfolio->save()){
             return redirect('admin')->with('status', 'Портфолио добавлено');
          }

       }

       if(view()->exists('admin.portfolios_add')){
          $data = [
             'title'=>'Новое портфолио'
          ];
          return view('admin.portfolios_add', $data);
       }
       abort(404);
    }

}
