<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpMaster extends Model
{
     protected $table = 'EmpMaster';
	 protected $primaryKey = 'EmpID';
	 public $timestamps = false;
}
