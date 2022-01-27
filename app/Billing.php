<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Billing extends Model
{
  //for SoftDeletes
  use SoftDeletes;
  //Second Way
  protected $guarded = [];
}
