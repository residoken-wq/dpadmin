<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    //
    protected $table='DT_Log';
   	protected $primary='id';
   	protected $timestamp=true;
   	public function Form(){
   		return $this->belongsTo(Forms::class,"cid_form")->getResults();
   	}
   	public function User(){
   		return $this->belongsTo(Users::class,"cid_user")->getResults();
   	}
}
