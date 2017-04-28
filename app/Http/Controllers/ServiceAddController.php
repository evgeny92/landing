<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceAddController extends Controller
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
            'name'=>'required|unique:services|max:255',
            'text'=>'required',

         ], $messages);

         //вернёт true если будет ошибка
         if($validator->fails()){
            return redirect()->route('serviceAdd')->withErrors($validator)->withInput();
         }

         //добавление в инф в бд
         $services = new Service();
         //метод заполняет поля модели данными, которые хранятся в массиве и передаются
         //в качестве первого аргумента
         $services->fill($input);

         //сохранение, если true то редирект
         if($services->save()){
            return redirect('admin')->with('status', 'Сервис добавлен');
         }
      }

      if(view()->exists('admin.services_add')){
         $data = [
            'title'=>'Новый сервис'
         ];
         return view('admin.services_add', $data);
      }

      abort(404);
   }
}
