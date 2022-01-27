<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
  //for SoftDeletes
  use SoftDeletes;
  //Second Way
  protected $guarded = [];
}
