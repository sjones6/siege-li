<?php

namespace App;

// Framework
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// Packages

// Application

class User extends Model
{

  use SoftDeletes;

  /**
  * @var string | table name
  **/
  protected $table = {{table}};

}
