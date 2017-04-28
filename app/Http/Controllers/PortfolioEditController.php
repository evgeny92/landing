<?php

namespace App\Http\Controllers;

use App\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PortfolioEditController extends Controller
{
   public function execute(Portfolio $portfolio, Request $request){

      //удаление страницы
      if($request->isMethod('delete')){
         $portfolio->delete();
         return redirect('admin')->with('status', 'Портфолио удалено');
      }

      //если метод пост
      if($request->isMethod('post')){

         $input = $request->except('_token');

         $validator = Validator::make($input, [
            'name'=>'required|max:255',
            'filter'=>'required|max:255|unique:portfolios,filter,'.$input['id']
         ]);

         if($validator->fails()){
            //route('pagesEdit', ['page'])->идентификатор pages/edit/1
            return redirect()
               ->route('portfolioEdit', ['portfolio'=>$input['id']])
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
         $portfolio->fill($input);
         //пересохраняем
         if($portfolio->update()){
            return redirect('admin')->with('status', 'Портфолио обновлено');
         }
      }

      //приводим к массиву
      $old = $portfolio->toArray();

      if(view()->exists('admin.portfolios_edit')){

         $data = [
            'title'=>'Редактирование портфолио - '.$old['name'],
            'data'=>$old
         ];
         return view('admin.portfolios_edit', $data);
      }
   }
}
