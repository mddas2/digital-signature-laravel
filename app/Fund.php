<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    public $fillable = ['payee_id','account_no','amount','remarks','name'];
}
