<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    //
    use SoftDeletes;
    protected $fillable = ['category_name', 'category_description', 'category_photo'];

    function prodctonetoone(){
      return $this->hasOne('App\Category', 'id', 'category_id')->withTrashed();
    }
    //Relationship with product table so create a function on other table
    //and call product table on category table
    function productonetomany(){
      return $this->hasMany('App\Product', 'category_id', 'id')->withTrashed();
    }
}
