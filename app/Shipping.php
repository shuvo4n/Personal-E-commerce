<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipping extends Model
{
  //for SoftDeletes
  use SoftDeletes;
  //Second Way
  protected $guarded = [];
}
