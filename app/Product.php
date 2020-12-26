<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{

    //One Way
    //protected $fillable = ['category_id','product_name','product_short_description','product_long_description','product_price','product_quantity','product_alert_quantity'];
    //for SoftDeletes
    use SoftDeletes;
    //Second Way
    protected $guarded = [];

    //Relationship function
    function onetoone(){
      return $this->hasOne('App\Category', 'id', 'category_id')->withTrashed();
    }
    function onetomany(){
      return $this->hasMany('App\Product_image', 'product_id', 'id')->withTrashed();
    }


}
