<?php

require_once '../vendor/autoload.php';


use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';
    protected $fillable = ['first_name', 'last_name', 'email'];
}