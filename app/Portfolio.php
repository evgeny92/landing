<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
   //список полей разрешённых к заполнению
   protected $fillable = ['name', 'images', 'filter'];
}
