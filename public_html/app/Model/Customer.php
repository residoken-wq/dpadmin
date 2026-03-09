<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $table = 'DT_Customer';
    protected $primary = 'id';
    protected $timestamp = true;

    public function Form()
    {
        return $this->hasMany(Forms::class, "cid_customer")->getResults();
    }

    public function phieudichthuat()
    {
        return $this->hasMany(Forms::class, "cid_customer");
    }

}
