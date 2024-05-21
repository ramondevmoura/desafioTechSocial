<?php

require_once '../vendor/autoload.php';


use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    protected $fillable = ['user_id', 'quantity', 'price'];
}