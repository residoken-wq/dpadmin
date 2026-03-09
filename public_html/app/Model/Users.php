<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Users extends Model
{
    //
    protected $table = 'users';
    protected $primary = 'id';
    protected $timestamp = true;
    protected $fillable = [
        'name',
        'username',
        'password',
        'phone',
        'email',
        'note',
        'remember_token',
        'storage_token',
        'roles',
    ];

    public function isSuppler()
    {
        if (Auth::check()) {
            if (Auth::user()->roles == '1') {
                return true;
            }
        }
        return false;
    }
}
