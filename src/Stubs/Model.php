<?php

namespace {{namespace}};

// Framework
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// Packages

// Application

class {{model}} extends Model
{

  use SoftDeletes;

  /**
  * @var string | table name
  **/
  protected $table = '{{table}}s';

  /**
  * @var string | guarded attributes
  **/
  protected $guarded = [];

  /**
  * @var string | column name of primary key attribute
  **/
  protected $primaryKey = '{{primary_key}}';

}
