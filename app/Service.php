<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
   //список полей разрешённых к заполнению
   protected $fillable = ['name', 'text', 'icon'];
}
