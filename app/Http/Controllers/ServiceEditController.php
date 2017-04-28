<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceEditController extends Controller
{
   public function execute(Service $service, Request $request){

      //удаление страницы
      if($request->isMethod('delete')){
         $service->delete();
         return redirect('admin')->with('status', 'Старинаца удалена');
      }

      //если метод пост
      if($request->isMethod('post')){

         $input = $request->except('_token');

         $validator = Validator::make($input, [
            'name'=>'required|max:255|unique:services,name,'.$input['id'],
            'text'=>'required',
         ]);

         if($validator->fails()){
            //route('pagesEdit', ['page'])->идентификатор pages/edit/1
            return redirect()
               ->route('serviceEdit', ['service'=>$input['id']])
               ->withErrors($validator);
         }

         //заполняем модель новыми значениями
         $service->fill($input);
         //пересохраняем
         if($service->update()){
            return redirect('admin')->with('status', 'Сервис обновлён');
         }
      }

      //приводим к массиву
      $old = $service->toArray();

      if(view()->exists('admin.services_edit')){

         $data = [
            'title'=>'Редактирование сервиса - '.$old['name'],
            'data'=>$old
         ];
         return view('admin.services_edit', $data);
      }
   }
}
