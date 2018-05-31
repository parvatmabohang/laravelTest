<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function attributes()
    {
        return $this->hasMany('App\Pattribute','product_id');
    }
    public function images()
    {
        return $this->hasMany('App\Pimage','product_id');
    }
}
