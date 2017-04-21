<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class People extends Model
{
   /*
    * переопределить закрытое свойство
    * имя табл. с которой будет работать текущая модель
    */
    protected $table = 'peoples';
}
